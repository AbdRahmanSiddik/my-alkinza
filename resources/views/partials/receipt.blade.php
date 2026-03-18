<div id="tmp-print" class="receipt">
    <div class="text-center mb-2">
        <img src="{{ Session::get('toko.logo') }}" width="100" style="filter: grayscale(1)">
        <h6>{{ session('toko.name') }}</h6>
    </div>

    <p>
        Invoice: {{ $print->kode_transaksi }}<br>
        Tanggal: {{ $print->created_at->format('d M Y H:i') }}<br>
        Pelanggan: {{ $print->nama_pelanggan ?? '-' }}
    </p>

    <table class="w-100">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th class="text-end">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($print->produkPivot as $item)
            <tr>
                <td>
                    {{ $item->produk->name }}<br>
                    <small>@rupiah($item->produk->harga) / {{ $item->produk->satuan }}</small>
                </td>
                <td>{{ $item->kuantitas }}</td>
                <td class="text-end">@rupiah($item->subtotal)</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <hr>

    <table class="w-100">
        <tr>
            <td>Subtotal</td>
            <td class="text-end">@rupiah($print->subtotal)</td>
        </tr>
        <tr>
            <td>Bayar</td>
            <td class="text-end">@rupiah($print->bayar)</td>
        </tr>
        <tr>
            <td>Kembali</td>
            <td class="text-end">@rupiah($print->kembali)</td>
        </tr>
    </table>

    <p class="text-center mt-2">
        <em>Terima kasih 🙏</em>
    </p>
</div>
