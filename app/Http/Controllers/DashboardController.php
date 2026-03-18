<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TransaksiProduct;
use App\Models\Product;
use App\Models\Kategori;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard (view)
     */
    public function index()
    {
        return view('dashboard-ai');
    }

    /**
     * Get data dashboard via AJAX (JSON)
     */
    public function getData(Request $request)
    {
        $toko_id = Session::get('toko.id');

        // ========== TENTUKAN PERIODE TANGGAL ==========
        $tanggal_awal = Carbon::today()->startOfDay();
        $tanggal_akhir = Carbon::today()->endOfDay();
        $periode_label = 'Hari Ini';

        // Filter custom range
        if ($request->has('tanggal_awal') && $request->has('tanggal_akhir')) {
            $tanggal_awal = Carbon::parse($request->tanggal_awal)->startOfDay();
            $tanggal_akhir = Carbon::parse($request->tanggal_akhir)->endOfDay();
            $periode_label = $tanggal_awal->format('d M Y') . ' - ' . $tanggal_akhir->format('d M Y');
        }

        // Filter bulan
        if ($request->has('bulan')) {
            $tanggal_awal = Carbon::parse($request->bulan)->startOfMonth();
            $tanggal_akhir = Carbon::parse($request->bulan)->endOfMonth();
            $periode_label = $tanggal_awal->format('F Y');
        }

        // ========== 1. TOTAL PENJUALAN & TRANSAKSI SELESAI ==========
        $transaksi_selesai = Transaksi::where('toko_id', $toko_id)
            ->where('status', 'selesai')
            ->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
            ->selectRaw(
                '
                COUNT(*) as total_transaksi,
                SUM(total_harga) as total_pendapatan,
                SUM(kuantitas) as total_item,
                SUM(bayar) as total_bayar,
                SUM(diskon) as total_diskon
            ',
            )
            ->first();

        // ========== 2. TRANSAKSI PENDING ==========
        $transaksi_pending = Transaksi::where('toko_id', $toko_id)
            ->whereIn('status', ['pending', 'menanti', 'proses'])
            ->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
            ->count();

        // ========== 3. TRANSAKSI KERANJANG (BELUM CHECKOUT) ==========
        $transaksi_keranjang = Transaksi::where('toko_id', $toko_id)
            ->where('status', 'keranjang')
            ->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
            ->count();

        // ========== 4. TRANSAKSI BATAL ==========
        $transaksi_batal = Transaksi::where('toko_id', $toko_id)
            ->where('status', 'batal')
            ->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
            ->count();

        // ========== 5. PENDAPATAN PER KATEGORI ==========
        $pendapatan_kategori = DB::table('transaksi_products')
            ->join('products', 'transaksi_products.produk_id', '=', 'products.id')
            ->join('kategoris', 'products.kategori_id', '=', 'kategoris.id')
            ->join('transaksis', 'transaksi_products.kode_transaksi', '=', 'transaksis.kode_transaksi')
            ->where('transaksis.toko_id', $toko_id)
            ->where('transaksis.status', 'selesai')
            ->whereBetween('transaksis.created_at', [$tanggal_awal, $tanggal_akhir])
            ->select(
                'kategoris.name as kategori',
                DB::raw('SUM(transaksi_products.subtotal) as total_pendapatan'),
                DB::raw('SUM(
            CASE
                WHEN products.satuan = "gram" THEN 1
                ELSE transaksi_products.kuantitas
            END
        ) as total_terjual'),
            )
            ->groupBy('kategoris.id', 'kategoris.name')
            ->orderByDesc('total_pendapatan')
            ->get();

        // ========== 6. GRAFIK PENJUALAN PER HARI ==========
        $grafik_penjualan = Transaksi::where('toko_id', $toko_id)
            ->where('status', 'selesai')
            ->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
            ->selectRaw(
                '
                DATE(created_at) as tanggal,
                COUNT(*) as jumlah_transaksi,
                SUM(total_harga) as pendapatan
            ',
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        // ========== 7. METODE PEMBAYARAN (Jenis Transaksi) ==========
        $metode_pembayaran = Transaksi::where('toko_id', $toko_id)
            ->where('status', 'selesai')
            ->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
            ->selectRaw(
                '
                jenis_transaksi,
                COUNT(*) as jumlah,
                SUM(total_harga) as total
            ',
            )
            ->groupBy('jenis_transaksi')
            ->get();

        // ========== 8. TRANSAKSI TERBARU ==========
        $transaksi_terbaru = Transaksi::where('toko_id', $toko_id)
            ->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
            ->with(['kasir:id,name', 'meja:id,nomor_meja,kode_meja'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // ========== RESPONSE ==========
        return response()->json([
            'periode' => [
                'label' => $periode_label,
                'dari' => $tanggal_awal->format('Y-m-d'),
                'sampai' => $tanggal_akhir->format('Y-m-d'),
            ],
            'ringkasan' => [
                'total_transaksi' => $transaksi_selesai->total_transaksi ?? 0,
                'total_pendapatan' => $transaksi_selesai->total_pendapatan ?? 0,
                'total_item' => $transaksi_selesai->total_item ?? 0,
                'total_diskon' => $transaksi_selesai->total_diskon ?? 0,
                'transaksi_pending' => $transaksi_pending,
                'transaksi_keranjang' => $transaksi_keranjang,
                'transaksi_batal' => $transaksi_batal,
            ],
            'pendapatan_kategori' => $pendapatan_kategori,
            'grafik_penjualan' => $grafik_penjualan,
            'metode_pembayaran' => $metode_pembayaran,
            'transaksi_terbaru' => $transaksi_terbaru,
        ]);
    }
}
