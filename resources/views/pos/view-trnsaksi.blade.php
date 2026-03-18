{{-- <!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Struk Transaksi</title>
  <style>
    body { font-family: Arial, sans-serif; font-size: 14px; padding: 20px; }
    .text-center { text-align: center; }
    .text-end { text-align: right; }
    .fw-bold { font-weight: bold; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    td, th { padding: 4px; }
    .border-top { border-top: 1px dashed #000; margin-top: 10px; padding-top: 10px; }
    @media print {
      .btn-print { display: none; }
    }
  </style>
</head>
<body>

  <div class="text-center">
    <img src="{{ asset(Session::get('toko.logo')) }}" width="100" alt="Logo">
    <h3>{{ Session::get('toko.name') }}</h3>
    <p>{{ Session::get('toko.addres') }}</p>
  </div>

  <hr>

  <table>
    <tr>
      <td><strong>No Transaksi:</strong></td>
      <td>{{ $transaksi->kode_transaksi }}</td>
    </tr>
    <tr>
      <td><strong>Nama Pelanggan:</strong></td>
      <td>{{ $transaksi->nama_pelanggan ?? '-' }}</td>
    </tr>
    <tr>
      <td><strong>No HP:</strong></td>
      <td>{{ $transaksi->no_telepon ?? '-' }}</td>
    </tr>
    <tr>
      <td><strong>Tanggal:</strong></td>
      <td>{{ $transaksi->created_at->format('d/m/Y H:i:s') }}</td>
    </tr>
  </table>

  <hr>

  <table border="1">
    <thead>
      <tr>
        <th>Item</th>
        <th>Harga</th>
        <th>Qty</th>
        <th class="text-end">Subtotal</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($transaksi->produkPivot as $pivot)
        <tr>
          <td>{{ $pivot->produk->name }}</td>
          <td>Rp {{ number_format($pivot->produk->harga ?? $pivot->harga, 0, ',', '.') }}</td>
          <td>
            @if ($pivot->produk->satuan == 'gram')
              {{ number_format($pivot->items->berat, 0, ',', '.') }} gr
            @else
              {{ $pivot->kuantitas }}
            @endif
          </td>
          <td class="text-end">
            @if ($pivot->produk->satuan == 'gram')
              Rp {{ number_format($pivot->items->harga, 0, ',', '.') }}
            @else
              Rp {{ number_format($pivot->harga, 0, ',', '.') }}
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div class="border-top">
    <table>
      <tr>
        <td class="fw-bold">Total Harga:</td>
        <td class="text-end">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <td class="fw-bold">Diskon:</td>
        <td class="text-end">{{ $transaksi->diskon }}%</td>
      </tr>
      <tr>
        <td class="fw-bold">Total Dibayar:</td>
        <td class="text-end">
          Rp {{ number_format($transaksi->total_harga - ($transaksi->total_harga * $transaksi->diskon / 100), 0, ',', '.') }}
        </td>
      </tr>
    </table>
  </div>

  <div class="text-center mt-3 mb-4">
    <p>Terima kasih telah berbelanja!</p>
    <button class="btn-print" onclick="window.location.href='/kasir'">Kembali</button>
    <button class="btn-print" onclick="window.print()">Cetak Struk</button>
  </div>

</body>
</html> --}}

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Struk Transaksi</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 14px;
      padding: 20px;
    }

    .struk-wrapper {
      width: 270px;
      /* Untuk printer thermal 58mm */
      margin: 0 auto;
    }

    .text-center {
      text-align: center;
    }

    .text-end {
      text-align: right;
    }

    .fw-bold {
      font-weight: bold;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    td,
    th {
      padding: 4px;
    }

    .border-top {
      border-top: 1px dashed #000;
      margin-top: 10px;
      padding-top: 10px;
    }

    /* Tombol Styling */
    .btn-print,
    .btn-rawbt {
      display: inline-block;
      padding: 10px 20px;
      margin: 10px 5px 0;
      background-color: #333;
      color: #fff;
      border: none;
      border-radius: 6px;
      text-decoration: none;
      font-size: 14px;
      cursor: pointer;
    }

    .btn-rawbt {
      background-color: #007bff;
    }

    @media print {

      .btn-print,
      .btn-rawbt {
        display: none;
      }
    }
  </style>
</head>

<body>

  <div class="struk-wrapper">

    <div class="text-center">
      <img src="{{ asset(Session::get('toko.logo')) }}" width="100" alt="Logo">
      <h3>{{ Session::get('toko.name') }}</h3>
      <p>{{ Session::get('toko.addres') }}</p>
    </div>

    <hr>

    <table>
      <tr>
        <td><strong>No Transaksi:</strong></td>
        <td>{{ $transaksi->kode_transaksi }}</td>
      </tr>
      <tr>
        <td><strong>Nama Pelanggan:</strong></td>
        <td>{{ $transaksi->nama_pelanggan ?? '-' }}</td>
      </tr>
      <tr>
        <td><strong>No HP:</strong></td>
        <td>{{ $transaksi->no_telepon ?? '-' }}</td>
      </tr>
      <tr>
        <td><strong>Tanggal:</strong></td>
        <td>{{ $transaksi->created_at->format('d/m/Y H:i:s') }}</td>
      </tr>
    </table>

    <hr>

    <table border="1">
      <thead>
        <tr>
          <th>Item</th>
          <th>Harga</th>
          <th>Qty</th>
          <th class="text-end">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($transaksi->produkPivot as $pivot)
          <tr>
            <td>{{ $pivot->produk->name }}</td>
            <td>Rp {{ number_format($pivot->produk->harga ?? $pivot->harga, 0, ',', '.') }}</td>
            <td>
              @if ($pivot->produk->satuan == 'gram')
                {{ number_format($pivot->items->berat, 0, ',', '.') }} gr
              @else
                {{ $pivot->kuantitas }}
              @endif
            </td>
            <td class="text-end">
              @if ($pivot->produk->satuan == 'gram')
                Rp {{ number_format($pivot->items->harga, 0, ',', '.') }}
              @else
                Rp {{ number_format($pivot->harga, 0, ',', '.') }}
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="border-top">
      <table>
        <tr>
          <td class="fw-bold">Total Harga:</td>
          <td class="text-end">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
        </tr>
        <tr>
          <td class="fw-bold">Diskon:</td>
          <td class="text-end">{{ $transaksi->diskon }}%</td>
        </tr>
        <tr>
          <td class="fw-bold">Total Dibayar:</td>
          <td class="text-end">
            Rp
            {{ number_format($transaksi->total_harga - ($transaksi->total_harga * $transaksi->diskon) / 100, 0, ',', '.') }}
          </td>
        </tr>
      </table>
    </div>

    <div class="text-center mt-3 mb-4">
      <p>Terima kasih telah berbelanja!</p>

      <button class="btn-print" onclick="window.location.href='/kasir'">Kembali</button>
      <button class="btn-print" onclick="window.print()">Cetak Struk</button>

      {{-- Tombol Cetak via RawBT --}}
      @php
        $text = "Struk Transaksi\n";
        $text .= "No: {$transaksi->kode_transaksi}\n";
        $text .= "Tanggal: {$transaksi->created_at->format('d/m/Y H:i:s')}\n";
        foreach ($transaksi->produkPivot as $pivot) {
            $nama = $pivot->produk->name;
            $qty =
                $pivot->produk->satuan == 'gram'
                    ? number_format($pivot->items->berat, 0, ',', '.') . 'gr'
                    : $pivot->kuantitas;
            $harga = number_format($pivot->produk->harga ?? $pivot->harga, 0, ',', '.');
            $text .= "- {$nama} x{$qty} : Rp{$harga}\n";
        }
        $text .= "------------------\n";
        $text .= 'Total: Rp ' . number_format($transaksi->total_harga, 0, ',', '.') . "\n";
        $text .= "Diskon: {$transaksi->diskon}%\n";
        $text .=
            'Bayar: Rp ' .
            number_format($transaksi->total_harga - ($transaksi->total_harga * $transaksi->diskon) / 100, 0, ',', '.') .
            "\n";
        $text .= 'Terima kasih 🙏';

        $rawbt_url = 'rawbt://print?text=' . urlencode($text);
      @endphp

      <a href="{{ $rawbt_url }}" class="btn-rawbt">Cetak via RawBT</a>
    </div>

  </div>

</body>

</html>
