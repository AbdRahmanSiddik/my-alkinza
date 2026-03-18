<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    public function index()
    {
        $tokoId = Session::get('toko.id');
        $kategoris = Kategori::where('toko_id', $tokoId)->get();
        return view('admin.kategori.kategori', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'nama_kategori' => [
                    'required',
                    'string',
                    'max:255',
                    // Rule::unique('kategoris', 'name')
                ],
            ],
            [
                'gambar.required' => 'Gambar kategori wajib diisi.',
                'gambar.image' => 'File yang diunggah harus berupa gambar.',
                'gambar.mimes' => 'Gambar harus dalam format: jpeg, png, jpg, gif, svg.',
                'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
                'nama_kategori.required' => 'Nama kategori wajib diisi.',
                'nama_kategori.string' => 'Nama kategori harus berupa teks.',
                'nama_kategori.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
                // 'nama_kategori.unique' => 'Nama kategori sudah ada, silakan gunakan nama lain.',
            ]
        );

        $kategori = new Kategori();
        $kategori->toko_id = Session::get('toko.id'); // Ganti dengan ID toko yang sesuai
        $kategori->token_kategori = Str::random(8);
        $kategori->name = $request->nama_kategori;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $randomName = Str::random(16) . '.' . $file->getClientOriginalExtension();
            $file->move('gambar/kategori', $randomName);
            $kategori->icon = 'gambar/kategori/' . $randomName;
        }
        $kategori->save();
        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate(
            [
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'nama_kategori' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('kategoris', 'name')->ignore($kategori->token_kategori, 'token_kategori')
                ],
            ],
            [
                'gambar.image' => 'File yang diunggah harus berupa gambar.',
                'gambar.mimes' => 'Gambar harus dalam format: jpeg, png, jpg, gif, svg.',
                'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
                'nama_kategori.required' => 'Nama kategori wajib diisi.',
                'nama_kategori.string' => 'Nama kategori harus berupa teks.',
                'nama_kategori.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
                'nama_kategori.unique' => 'Nama kategori sudah ada, silakan gunakan nama lain.',
            ]
        );

        $kategori->name = $request->nama_kategori;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $randomName = Str::random(16) . '.' . $file->getClientOriginalExtension();
            $file->move('gambar/kategori', $randomName);

            if ($kategori->icon && File::exists($kategori->icon)) {
                File::delete($kategori->icon);
            }

            $kategori->icon = 'gambar/kategori/' . $randomName;
        }
        $kategori->save();
        return redirect()->back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        if ($kategori->icon && File::exists($kategori->icon)) {
            File::delete($kategori->icon);
        }

        $kategori->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }
}
