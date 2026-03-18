<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TokoController extends Controller
{
    public function index()
    {
        $tokos = Toko::all();
        return view('admin.toko.toko-index', compact('tokos'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nama_toko' => [
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('tokos', 'name')
                ],
                'alamat_toko' => 'nullable|string|max:100',
                'deskripsi' => 'nullable|string',
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                'nama_toko.required' => 'Nama toko harus diisi.',
                'nama_toko.max' => 'Nama toko tidak boleh lebih dari 50 karakter.',
                'alamat_toko.max' => 'Alamat tidak boleh lebih dari 100 karakter.',
                'gambar.image' => 'File yang diunggah harus berupa gambar.',
                'gambar.mimes' => 'Gambar harus berformat jpeg, png, jpg.',
                'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
                'gambar.required' => 'Gambar toko harus diunggah.',
            ]
        );
        $toko = new Toko();
        $toko->token_toko = Str::random(8);
        $last = Toko::max('kode_toko');
        $number = $last ? ((int) substr($last, 2)) + 1 : 1;
        $toko->kode_toko = 'TK' . str_pad($number, 3, '0', STR_PAD_LEFT);
        $toko->name = $request->nama_toko;
        $toko->addres = $request->alamat_toko;
        $toko->deskripsi = $request->deskripsi;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $randomName = Str::random(16) . '.' . $file->getClientOriginalExtension();
            $file->move('gambar/toko', $randomName);
            $toko->logo = 'gambar/toko/' . $randomName;
        }
        $toko->save();

        if (!Session::has('toko')){
            $this->setSessionToko();
        }

        return redirect()->back()->with('success', 'Toko berhasil ditambahkan.');
    }

    public function update(Request $request, Toko $toko)
    {
        $request->validate(
            [
                'nama_toko' => [
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('tokos', 'name')->ignore($toko->token_toko, 'token_toko')
                ],
                'alamat_toko' => 'nullable|string|max:100',
                'deskripsi' => 'nullable|string',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                'nama_toko.required' => 'Nama toko harus diisi.',
                'nama_toko.max' => 'Nama toko tidak boleh lebih dari 50 karakter.',
                'alamat_toko.max' => 'Alamat tidak boleh lebih dari 100 karakter.',
                'gambar.image' => 'File yang diunggah harus berupa gambar.',
                'gambar.mimes' => 'Gambar harus berformat jpeg, png, jpg.',
                'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
            ]
        );

        $toko->name = $request->nama_toko;
        $toko->addres = $request->alamat_toko;
        $toko->deskripsi = $request->deskripsi;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $randomName = Str::random(16) . '.' . $file->getClientOriginalExtension();
            $file->move('gambar/toko', $randomName);

            if ($toko->logo && File::exists($toko->logo)) {
                File::delete($toko->logo);
            }

            $toko->logo = 'gambar/toko/' . $randomName;
        }

        $toko->save();
        return redirect()->back()->with('success', 'Toko berhasil diperbarui.');
    }

    public function destroy(Toko $toko)
    {
        if ($toko->produks()->exists()) {
            return redirect()->back()->with('error', 'Toko tidak dapat dihapus karena memiliki produk terkait.');
        }

        if ($toko->logo && File::exists($toko->logo)) {
            File::delete($toko->logo);
        }

        $toko->delete();
        return redirect()->back()->with('success', 'Toko berhasil dihapus.');
    }

    public function sessionToko($token)
    {
        $toko = Toko::where('token_toko', $token)->first();

        $this->setSessionToko($toko->id);

        return redirect()->back()->with('success', 'Toko berhasil dipilih.');
    }

    public function setSessionToko($tokoId = null)
    {
        if (Session::has('toko')) {
            Session::forget('toko');
        }

        if ($tokoId != null) { // menangani jika tombol pilih toko ditekan
            $toko = Toko::where('id', $tokoId)->first();
            Session::put('toko', [
                'id' => $toko->id,
                'token' => $toko->token_toko,
                'kode' => $toko->kode_toko,
                'name' => $toko->name,
                'logo' => $toko->logo,
            ]);
        } else {
            $toko = Auth::user()->toko()->first();
            if ($toko) { // menangani jika user sudah memiliki toko(operator & kasir) & belum memilih toko
                Session::put('toko', [
                    'id' => $toko->id,
                    'token' => $toko->token_toko,
                    'kode' => $toko->kode_toko,
                    'name' => $toko->name,
                    'logo' => $toko->logo,
                ]);
            } else { // menagani jika yang login adalah admin & tidak ada toko yang dipilih
                $toko = Toko::first();
                Session::put('toko', [
                    'id' => $toko->id,
                    'token' => $toko->token_toko,
                    'kode' => $toko->kode_toko,
                    'name' => $toko->name,
                    'logo' => $toko->logo,
                ]);
            }
        }
    }
}
