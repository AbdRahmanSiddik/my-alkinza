<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MejaController extends Controller
{
    public function index()
    {
        $tokoId = session('toko.id');
        $mejas = Meja::where('toko_id', $tokoId)
            ->get();
        return view('admin.meja.meja-index', compact('mejas'));
    }

    public function store(Request $request)
    {
        $tokoId = session('toko.id');
        $toko = Toko::findOrFail($tokoId);

        $lastMeja = Meja::where('toko_id', $tokoId)
            ->orderByDesc('nomor_meja')
            ->first();

        $nextNomor = $lastMeja ? (int)$lastMeja->nomor_meja + 1 : 1;
        $formattedNomor = str_pad($nextNomor, 3, '0', STR_PAD_LEFT);

        $kodeMeja = $toko->kode_toko . '-' . $formattedNomor;

        Meja::create([
            'token_meja'  => Str::random(8),
            'toko_id'     => $tokoId,
            'nomor_meja'  => $formattedNomor, // <- simpan 3 digit string
            'kode_meja'   => $kodeMeja,       // contoh: TK001-003
        ]);

        return redirect()->back()->with('success', 'Meja baru berhasil ditambahkan.');
    }

    public function destroy(Meja $meja)
    {
        $tokoId = session('toko.id');

        $lastMeja = Meja::where('toko_id', $tokoId)->orderByDesc('nomor_meja')->first();

        if ($lastMeja && $meja->id === $lastMeja->id) {
            $meja->delete();
            return redirect()->back()->with('success', 'Meja berhasil dikurangi.');
        }

        return redirect()->back()->with('error', 'Hanya meja terakhir yang bisa dihapus.');
    }
}
