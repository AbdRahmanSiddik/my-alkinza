<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk Transaksi - {{ $print->kode_transaksi }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.4;
            padding: 10px;
            max-width: 80mm;
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
        
        .border-dashed {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 8px 0;
            margin: 8px 0;
        }
        
        .header {
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #000;
        }
        
        .logo {
            max-width: 60px;
            margin: 0 auto 10px;
        }
        
        .shop-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .invoice-info {
            margin: 10px 0;
            font-size: 11px;
        }
        
        .invoice-info-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        
        th {
            text-align: left;
            padding: 5px 0;
            border-bottom: 1px solid #000;
            font-weight: bold;
        }
        
        td {
            padding: 3px 0;
            vertical-align: top;
        }
        
        .item-name {
            max-width: 150px;
        }
        
        .item-qty {
            text-align: center;
            width: 40px;
        }
        
        .item-price, .item-total {
            text-align: right;
            width: 80px;
        }
        
        .total-section {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dashed #000;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }
        
        .total-row.grand-total {
            font-weight: bold;
            font-size: 13px;
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px solid #000;
        }
        
        .footer {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px dashed #000;
            text-align: center;
            font-size: 11px;
        }
        
        .small {
            font-size: 10px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header text-center">
        <div class="shop-name">{{ Session::get('toko.name') }}</div>
        <div class="small">Struk Transaksi</div>
    </div>
    
    <!-- Invoice Information -->
    <div class="invoice-info">
        <div class="invoice-info-row">
            <span>No Transaksi</span>
            <span class="fw-bold">{{ $print->kode_transaksi }}</span>
        </div>
        <div class="invoice-info-row">
            <span>Tanggal</span>
            <span>{{ $print->created_at->format('d/m/Y H:i') }}</span>
        </div>
        @if($print->nama_pelanggan)
        <div class="invoice-info-row">
            <span>Pelanggan</span>
            <span>{{ $print->nama_pelanggan }}</span>
        </div>
        @endif
        @if($print->kasir)
        <div class="invoice-info-row">
            <span>Kasir</span>
            <span>{{ $print->kasir->name }}</span>
        </div>
        @endif
    </div>
    
    <!-- Items Table -->
    <table>
        <thead>
            <tr>
                <th class="item-name">Item</th>
                <th class="item-qty">Qty</th>
                <th class="item-price">Harga</th>
                <th class="item-total">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($print->produkPivot as $item)
            <tr>
                <td class="item-name">{{ $item->produk->name }}</td>
                <td class="item-qty">{{ $item->kuantitas }}</td>
                <td class="item-price">{{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                <td class="item-total">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Total Section -->
    <div class="total-section">
        <div class="total-row">
            <span>Subtotal</span>
            <span>Rp {{ number_format($print->subtotal, 0, ',', '.') }}</span>
        </div>
        <div class="total-row grand-total">
            <span>Total</span>
            <span>Rp {{ number_format($print->total_harga, 0, ',', '.') }}</span>
        </div>
        <div class="total-row">
            <span>Bayar</span>
            <span>Rp {{ number_format($print->bayar, 0, ',', '.') }}</span>
        </div>
        <div class="total-row">
            <span>Kembali</span>
            <span>Rp {{ number_format($print->kembali, 0, ',', '.') }}</span>
        </div>
    </div>
    
    <!-- Footer -->
    <div class="footer">
        <p>Terima kasih telah berbelanja</p>
        <p>Selamat menikmati!</p>
        <div class="small" style="margin-top: 10px;">
            <p>{{ Session::get('toko.name') }}</p>
        </div>
    </div>
</body>
</html>
