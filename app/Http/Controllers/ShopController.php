<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Meja;
use App\Models\Product;
use App\Models\Toko;
use App\Models\Transaksi;
use App\Models\TransaksiProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    public function index()
    {
        return view('shop.shop-index');
    }

    public function menu($token_toko)
    {
        $shop = Toko::where('token_toko', $token_toko)->firstOrFail();
        $kategori = Kategori::where('toko_id', $shop->id)->pluck('name', 'id')->toArray();
        $meja = Meja::where('toko_id', $shop->id)->pluck('nomor_meja', 'id')->toArray();

        $queryProduk = Product::where('toko_id', $shop->id)->where('satuan', '!=', 'gram');

        if (request()->filled('kategori')) {
            $queryProduk->where('kategori_id', request()->kategori);
        }

        if (request()->filled('search')) {
            $search = request()->search;
            $queryProduk->where('name', 'like', "%$search%");
        }

        if(Auth::check()){
            $activeProduk = $this->_activeProduk();
            $activeMeja = $this->_activeMeja();
        }else{
            $activeProduk = [];
            $activeMeja = [];
        }

        $produk = $queryProduk->get();

        if (request()->ajax()) {
            return response()->json([
                'html' => view('shop._produk-list', compact('produk', 'activeProduk'))->render(),
            ]);
        }

        return view('shop.shop-menu', compact('shop', 'kategori', 'produk', 'activeMeja', 'meja'));
    }

    private function _activeMeja()
    {
        $toko = Toko::where('token_toko', request()->route('token_toko'))->first();
        $meja = Transaksi::whereIn('status', ['pending', 'proses', 'keranjang'])
            ->where('toko_id', $toko->id)
            ->where('jenis_transaksi', 'ditempat')
            ->first();

        return $meja ? $meja->meja()->pluck('id')->toArray() : [];
    }

    private function _activeProduk()
    {
        $user = Auth::user();
        $toko = Toko::where('token_toko', request()->route('token_toko'))->first();
        $produk = Transaksi::where('status', 'keranjang')
            ->where('toko_id', $toko->id)
            ->where('user_id', $user->id)
            ->where('jenis_transaksi', 'pesanan')
            ->with(['produkPivot.produk'])
            ->first();

        return $produk ? $produk->produkPivot()->pluck('produk_id')->toArray() : [];
    }

    public function getDataKeranjang(Request $request)
    {
        $user = Auth::user();
        $toko = Toko::where('token_toko', $request->toko)->first();
        $keranjang = Transaksi::where('status', 'keranjang')
            ->where('toko_id', $toko->id)
            ->where('user_id', $user->id)
            ->where('jenis_transaksi', 'pesanan')
            ->with(['produkPivot.produk'])
            ->first();

        $count = optional($keranjang?->produkPivot)->count() ?? 0;
        $html = view('shop._card-list', compact('keranjang'))->render();
        return response()->json([
            'html' => $html,
            'count' => $count,
        ]);
    }

    public function postDataKeranjang(Request $request)
    {
        $user = Auth::user();
        $toko = Toko::where('token_toko', $request->toko)->firstOrFail();
        $produk = Product::where('id', $request->produk_id)->where('toko_id', $toko->id)->firstOrFail();
        $token = Str::random(10);

        $keranjang = Transaksi::where('status', 'keranjang')->where('toko_id', $toko->id)->where('user_id', $user->id)->where('jenis_transaksi', 'pesanan')->first();

        if (!$keranjang) {
            $keranjang = Transaksi::create([
                'kode_transaksi' => $token,
                'status' => 'keranjang',
                'toko_id' => $toko->id,
                'user_id' => $user->id,
                'jenis_transaksi' => 'pesanan',
                'nama_pelanggan' => $user->name,
            ]);
        }

        $keranjang->produkPivot()->create([
            'produk_id' => $produk->id,
            'kuantitas' => 1,
            'subtotal' => $produk->harga,
        ]);

        return response()->json(['message' => 'Produk berhasil ditambahkan ke keranjang.']);
    }

    public function updateKeranjang(Request $request)
    {
        $detail = TransaksiProduct::with('produk')->where('id', $request->id)->firstOrFail();
        $action = $request->action;

        if ($action == 'plus') {
            $detail->kuantitas += 1;
            $detail->subtotal = $detail->produk->harga * $detail->kuantitas;
            $detail->save();
        } elseif ($action == 'minus') {
            $detail->kuantitas -= 1;
            $detail->subtotal = $detail->produk->harga * $detail->kuantitas;
            $detail->save();
            if ($detail->kuantitas <= 0) {
                $detail->delete();
                return response()->json(['message' => 'Produk berhasil dihapus dari keranjang.']);
            }
        } elseif ($action == 'delete') {
            $detail->delete();
            return response()->json(['message' => 'Produk berhasil dihapus dari keranjang.']);
        }

        return response()->json(['message' => 'Keranjang berhasil diperbarui.', 'aksi' => $action]);
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();
        $toko = Toko::where('token_toko', $request->toko)->firstOrFail();
        $keranjang = Transaksi::where('status', 'keranjang')
        ->where('toko_id', $toko->id)
        ->where('user_id', $user->id)
        ->where('jenis_transaksi', 'pesanan')
        ->with(['produkPivot.produk'])
        ->first();

        if (!$keranjang || $keranjang->produkPivot->isEmpty()) {
            return response()->json([
                'message' => 'Keranjang kosong.',
            ], 422);
        }

        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'file.required' => 'File gambar wajib diunggah.',
            'file.image' => 'File harus berupa gambar.',
            'file.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau svg.',
            'file.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $kuantitasTotal = $keranjang->produkPivot->sum('kuantitas');
        $totalHarga = $keranjang->produkPivot->sum('subtotal');

        $keranjang->status = 'pending';
        $keranjang->kuantitas = $kuantitasTotal;
        $keranjang->total_harga = $totalHarga;
        $keranjang->meja_id = $request->meja ?? null;
        $keranjang->bayar = $totalHarga;
        $keranjang->created_at = now();
        $keranjang->save();

        $file = $request->file('file');
        $filename = $keranjang->kode_transaksi . '.' . $file->getClientOriginalExtension();
        $file->move('uploads/bukti_bayar', $filename);

        return response()->json([
            'message' => 'Checkout berhasil.',
            'success' => true,
        ]);
    }

    public function pesanan($token_toko)
    {
        $shop = Toko::where('token_toko', $token_toko)->firstOrFail();
        $user = Auth::user();
        $pesanan = Transaksi::where('toko_id', $shop->id)
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'proses', 'selesai', 'batal'])
            ->with(['meja', 'produkPivot.produk'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Tambahkan properti url_foto langsung ke setiap item pada $pesanan
        $pesanan = $pesanan->map(function ($item) {
            $nama_file = $item->kode_transaksi;
            $path = 'uploads/bukti_bayar';
            $extensions = ['jpg', 'jpeg', 'png'];
            $item->url_foto = null; // Default null dulu

            foreach ($extensions as $ext) {
                $file_path = public_path($path . '/' . $nama_file . '.' . $ext);
                if (file_exists($file_path)) {
                    $item->url_foto = asset($path . '/' . $nama_file . '.' . $ext);
                    break;
                }
            }
            return $item;
        });

        // Kirim hanya $pesanan saja (tidak perlu variabel $fotos)
        return view('shop.shop-pesanan', compact('shop', 'pesanan'));
    }
}
