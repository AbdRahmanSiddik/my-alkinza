<div class="container">
    @forelse($pesanan as $order)
        <div class="d-flex justify-content-between align-items-center border rounded p-3 mb-2" style="background: #f9f9f9;">
            <div>
            <div class="fw-bold">{{ $order->kode_transaksi }}</div>
            <div class="fw-bold">{{ $order->nama_pelanggan }}: {{ $order->no_telepon }}</div>
            <div class="text-muted small">
            {{ $order->created_at->format("d-m-y, H:i") }} &bull; Estimasi: {{ $order->created_at->addMinutes($order->estimasi)->format("d-m-y, H:i") }}
            </div>
            </div>
            <div class="text-end">
            @php
            $statusColors = [
                'pending' => 'color: #ffc107;', // yellow
                'proses' => 'color: #0d6efd;',  // blue
                'menanti' => 'color: #6c757d;', // gray
            ];
            $status = strtolower($order->status);
            @endphp
            <span style="{{ $statusColors[$status] ?? 'color: #212529;' }}">
            {{ ucfirst($order->status) }}
            </span>
            <br>
            <button class="btn btn-primary btn-sm mt-2 pesanan-btn" data-id="{{ $order->id }}" data-nomor="{{ $order->meja?->nomor_meja }}" data-meja="{{ $order->meja_id }}">Check</button>
            </div>
        </div>
    @empty
        <div class="alert alert-info text-center">
            Tidak ada pesanan Saat Ini.
        </div>
    @endforelse
</div>
