<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Product;
use App\Models\TransaksiProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $cat = $request->query('cat');

        $produk = Product::where('toko_id', Session::get('toko.id'));

        if ($cat) {
            $categori = Kategori::where('token_kategori', $cat)->first();
            if ($categori) {
                $produk->where('kategori_id', $categori->id);
            }
        }

        $data = [
            'products' => $produk->latest()->get(),
            'categories' => Kategori::where('toko_id', Session::get('toko.id'))->get()
        ];

        return view('admin.produk.produk-index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama' => 'required',
            'kategori' => 'required|exists:kategoris,id',
            'satuan' => 'required',
            'harga' => 'required',
        ], [
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Format gambar yang diperbolehkan: jpeg, png, jpg, gif, svg.',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
            'nama.required' => 'Nama produk wajib diisi.',
            'kategori.required' => 'Kategori produk wajib dipilih.',
            'kategori.exists' => 'Kategori produk tidak valid.',
            'satuan.required' => 'Satuan produk wajib diisi.',
            'harga.required' => 'Harga produk wajib diisi.',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $randomName = Str::random(16) . '.' . $file->getClientOriginalExtension();
            $file->move('gambar/produk', $randomName);
            $fileName = 'gambar/produk/' . $randomName;
        } else {
            $fileName = null;
        }

        $token = Str::random(8);
        // Remove all non-numeric characters from the price input
        $harga = preg_replace('/[^\d]/', '', $request->harga);

        Product::create([
            'token_product' => $token,
            'toko_id' => Session::get('toko.id'),
            'kategori_id' => $request->kategori,
            'name' => $request->nama,
            'foto' => $fileName,
            'harga' => $harga,
            'satuan' => $request->satuan,
            'stok' => $request->stok_cek == 'on' ? $request->stok : 0,
            'status_stok' => $request->stok_cek ?? 'off',
            'dedkripsi' => $request->deskripsi
        ]);

        return redirect()->back()->with('success', 'Berhasil Menambahkan Produk');
    }

    public function update(Request $request, Product $produk)
    {
        $request->validate([
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama' => 'required',
            'kategori' => 'required|exists:kategoris,id',
            'satuan' => 'required',
            'harga' => 'required',
        ]);

        $fileName = $produk->foto;

        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($produk->foto && File::exists($produk->foto)) {
                File::delete($produk->foto);
            }
            $file = $request->file('gambar');
            $randomName = Str::random(16) . '.' . $file->getClientOriginalExtension();
            $file->move('gambar/produk', $randomName);
            $fileName = 'gambar/produk/' . $randomName;
        }

        $harga = preg_replace('/[^\d]/', '', $request->harga);

        $produk->update([
            'kategori_id' => $request->kategori,
            'name' => $request->nama,
            'foto' => $fileName,
            'harga' => $harga,
            'satuan' => $request->satuan,
            'stok' => $request->stok_cek == 'on' ? $request->stok : 0,
            'status_stok' => $request->stok_cek ?? 'off',
            'dedkripsi' => $request->deskripsi
        ]);

        return redirect()->back()->with('success', 'Produk berhasil diupdate');
    }

    public function destroy(Product $produk)
    {
        // Delete produk image if exists
        if ($produk->foto && File::exists($produk->foto)) {
           File::delete($produk->foto);
        }

        $produk->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus');
    }

    public function stok(Request $request)
    {
        $cat = $request->query('cat');

        $produk = Product::where('toko_id', Session::get('toko.id'))
            ->withCount(['transaksiPivots as total_gram' => function ($query){
                $query->whereHas('transaksi', function ($q){
                    $q->where('status', 'selesai');
                });
            }])
            ->withSum(['transaksiPivots as total_terjual' => function ($query){
                $query->whereHas('transaksi', function ($q){
                    $q->where('status', 'selesai');
                });
            }], 'kuantitas');

        if ($cat) {
            $categori = Kategori::where('token_kategori', $cat)->first();
            if ($categori) {
                $produk->where('kategori_id', $categori->id);
            }
        }

        $data = [
            'products' => $produk->orderByRaw('COALESCE(total_terjual, 0) DESC')->get(),
            'categories' => Kategori::where('toko_id', Session::get('toko.id'))->get()
        ];

        return view('admin.produk.produk-stok', $data);
    }

    public function update_stok(Request $request, Product $product){
        // dd($request->all(), $product);
        if($request->has('stok_status')) {
            $request->validate([
                'stok_value' => 'required|integer|min:0',
                'stok_status' => 'in:on'
            ], [
                'stok_value.required' => 'Stok produk wajib diisi ketika status stok diaktifkan.',
                'stok_value.integer' => 'Stok produk harus berupa angka bulat.',
                'stok_value.min' => 'Stok produk tidak boleh kurang dari 0.',
                'stok_status.in' => 'Status stok tidak valid.'
            ]);
            $product->update([
                'stok' => $request->stok_value,
                'status_stok' => 'on'
            ]);
        } else {
            $product->update([
                'stok' => 0,
                'status_stok' => 'off'
            ]);
        }

        return redirect()->back()->with('success', 'Stok produk berhasil diupdate');
    }

    public function update_harga(Request $request, Product $product)
    {
        $request->validate([
            'harga' => 'required',
            'satuan' => 'required|in:pcs,gram,porsi'
        ], [
            'harga.required' => 'Harga produk wajib diisi.',
            'satuan.required' => 'Satuan produk wajib diisi.',
            'satuan.in' => 'Satuan produk tidak valid.'
        ]);

        $harga = preg_replace('/[^\d]/', '', $request->harga);

        $product->update([
            'harga' => $harga,
            'satuan' => $request->satuan
        ]);

        return redirect()->back()->with('success', 'Harga produk berhasil diupdate');
    }
}
