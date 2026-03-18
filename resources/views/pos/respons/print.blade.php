<div class="tax-invoice">
  <h6 class="text-center">Tax Invoice</h6>
  <div class="row">
    <div class="col-sm-12 col-md-6">
      <div class="invoice-user-name"><span>Name: </span>{{ $print->nama_pelanggan }}</div>
      <div class="invoice-user-name"><span>Invoice No: </span>{{ $print->kode_transaksi }}</div>
    </div>
    <div class="col-sm-12 col-md-6">
      <div class="invoice-user-name"><span>Date: </span>{{ $print->created_at->format('d M y') }}</div>
    </div>
  </div>
</div>
<table class="table-borderless w-100 table-fit">
  <thead>
    <tr>
      <th># Item</th>
      <th>Price</th>
      <th>Qty</th>
      <th class="text-end">Total</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($print->produkPivot as $item)
        <tr>
          <td>{{ $loop->iteration }}. {{ $item->produk->name }}</td>
          <td>@rupiah($item->produk->harga) <small>/ {{ $item->produk->satuan }}</small></td>
          <td>{{ $item->kuantitas }}</td>
          <td class="text-end">@rupiah($item->subtotal)</td>
        </tr>
    @endforeach
    <tr>
      <td colspan="4">
        <table class="table-borderless w-100 table-fit">
          <tr>
            <td class="fw-bold">Sub Total :</td>
            <td class="text-end">@rupiah($print->subtotal)</td>
          </tr>
          <tr>
            <td class="fw-bold">Bayar :</td>
            <td class="text-end">@rupiah($print->bayar)</td>
          </tr>
          <tr>
            <td class="fw-bold">Kembali :</td>
            <td class="text-end">@rupiah($print->kembali)</td>
          </tr>
          <tr>
            <td class="fw-bold">Total Transaksi :</td>
            <td class="text-end">@rupiah($print->total_harga)</td>
          </tr>
        </table>
      </td>
    </tr>
  </tbody>
</table>
