<div>

    <div class="row pos-wrapper m-2">

        <div class="col-md-12 col-lg-7 col-xl-8 d-flex flex-column" style="max-height: 100vh;">
            <div class="card w-100 d-flex flex-column" style="max-height: 100vh; overflow-y: auto; padding-bottom: 130px">
                <div class="card-header row">
                    <div class="col-lg-12 d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Daftar transaksi</h3>
                        <div class="card-tools d-flex gap-2">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-search" wire:loading.remove wire:target="search"></i>
                                    <i class="fas fa-spinner fa-spin" wire:loading wire:target="search"></i>
                                </span>
                                <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                                    placeholder="Cari customer/kode transaksi...">
                            </div>
                            <select wire:model.live.debounce.300ms="status" class="form-control">
                                <option value="selesai">Selesai</option>
                                <option value="pending">Pending</option>
                                <option value="keranjang">Keranjang</option>
                            </select>
                            <input type="date" wire:model.live.debounce.300ms="tanggal" class="form-control">
                            <button wire:click="$set('tanggal', '')" class="btn btn-primary">Semua</button>
                        </div>
                    </div>
                    <div class="row g-3 mt-3 border-top justify-content-center" style="overflow-x: auto;">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body py-2 px-3 d-flex align-items-center">
                                    <div class="me-2">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded d-flex align-items-center justify-content-center"
                                            style="width:38px;height:38px;">
                                            <i class="fas fa-wallet small"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block lh-sm">Total Pendapatan</small>
                                        <div class="fw-semibold">@rupiah($stats->sum('subtotal'))</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body py-2 px-3 d-flex align-items-center">
                                    <div class="me-2">
                                        <div class="bg-secondary bg-opacity-10 text-secondary rounded d-flex align-items-center justify-content-center"
                                            style="width:38px;height:38px;">
                                            <i class="fas fa-money-bill-wave small"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block lh-sm">Pembayaran Tunai</small>
                                        <div class="fw-semibold">@rupiah($stats->where('metode_pembayaran', 'tunai')->sum('subtotal'))</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body py-2 px-3 d-flex align-items-center">
                                    <div class="me-2">
                                        <div class="bg-dark bg-opacity-10 text-dark rounded d-flex align-items-center justify-content-center"
                                            style="width:38px;height:38px;">
                                            <i class="fas fa-credit-card small"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block lh-sm">Pembayaran NonTunai</small>
                                        <div class="fw-semibold">@rupiah($stats->where('metode_pembayaran', 'non-tunai')->sum('subtotal'))</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body py-2 px-3 d-flex align-items-center">
                                    <div class="me-2">
                                        <div class="bg-success bg-opacity-10 text-success rounded d-flex align-items-center justify-content-center"
                                            style="width:38px;height:38px;">
                                            <i class="fas fa-receipt small"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block lh-sm">Total Transaksi</small>
                                        <div class="fw-semibold">{{ $stats->count() }} Order</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body py-2 px-3 d-flex align-items-center">
                                    <div class="me-2">
                                        <div class="bg-warning bg-opacity-10 text-warning rounded d-flex align-items-center justify-content-center"
                                            style="width:38px;height:38px;">
                                            <i class="fas fa-box small"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block lh-sm">Total Item Terjual</small>
                                        <div class="fw-semibold">
                                            {{ $stats->sum(function ($transaction) {return $transaction->produkPivot->where('satuan', '!=', 'gram')->sum('kuantitas') + $transaction->produkPivot->where('satuan', 'gram')->count();}) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $totalNonGram = $stats->sum(function ($transaction) {
                                return $transaction->produkPivot->where('satuan', '!=', 'gram')->sum('kuantitas');
                            });

                            $totalGram = $stats->sum(function ($transaction) {
                                return $transaction->produkPivot->where('satuan', 'gram')->count();
                            });
                        @endphp

                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body py-2 px-3 d-flex align-items-center">

                                    {{-- ICON --}}
                                    <div class="me-2">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded d-flex align-items-center justify-content-center"
                                            style="width:38px;height:38px;">
                                            <i class="fas fa-boxes-stacked small"></i>
                                        </div>
                                    </div>

                                    {{-- CONTENT --}}
                                    <div>
                                        <small class="text-muted d-block lh-sm">Detail Item Terjual</small>

                                        <div class="fw-semibold">
                                            {{ number_format($totalNonGram) }} Item
                                            <span class="text-muted">|</span>
                                            {{ number_format($totalGram) }} Produk Gram
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode Transaksi</th>
                                    <th>Customer</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $transaction)
                                    <tr>
                                        <td>{{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration }}
                                        </td>
                                        <td>#{{ $transaction->kode_transaksi }}</td>
                                        <td>{{ $transaction->nama_pelanggan ?? '-' }}</td>
                                        <td>{{ $transaction->created_at->translatedFormat('l, d-m-Y, H:i:s') }}</td>
                                        <td>@rupiah($transaction->subtotal)<br>{{ $transaction->metode_pembayaran }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-info" type="button" data-bs-toggle="modal"
                                                data-bs-target="#transaction-detail-modal"
                                                wire:click="viewTransaction('{{ $transaction->kode_transaksi }}')">Lihat
                                                &
                                                Print</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada transaksi ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <span>Menampilkan {{ $transactions->firstItem() ?? 0 }} - {{ $transactions->lastItem() ?? 0 }}
                        dari
                        {{ $transactions->total() }} transaksi</span>
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-5 col-xl-4 ps-0 theiaStickySidebar">

        </div>

    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="transaction-detail-modal" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="page-title">
                        <h4>Detail Transaksi #{{ $detail->kode_transaksi ?? '' }}</h4>
                    </div>
                    <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    {{-- TABLE ITEM --}}
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-3">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center" style="width:80px;">Qty</th>
                                    <th class="text-end" style="width:150px;">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($detail?->produkPivot ?? [] as $item)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">
                                                {{ $item->produk->name }}
                                            </div>
                                            <small class="text-muted">
                                                @rupiah($item->produk->harga ?? 0) / {{ $item->produk->satuan }}
                                            </small>
                                        </td>

                                        <td class="text-center">
                                            {{ $item->kuantitas }}
                                        </td>

                                        <td class="text-end fw-semibold">
                                            @rupiah($item->subtotal)
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-3">
                                            Tidak ada data produk
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>


                    {{-- SUMMARY --}}
                    <div class="border-top pt-3">

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Transaksi</span>
                            <strong>
                                @rupiah($detail->subtotal ?? 0)
                            </strong>
                        </div>

                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">Metode Pembayaran</small>
                            <span>{{ $detail->metode_pembayaran ?? '-' }}</span>
                        </div>


                        @if ($detail?->metode_pembayaran == 'tunai')
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Bayar</small>
                                <span>{{ $detail->bayar ?? '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Kembali</small>
                                <span>{{ $detail->kembali ?? '-' }}</span>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Status</small>
                            <span class="badge bg-info">
                                {{ $detail->status ?? '-' }}
                            </span>
                        </div>

                    </div>

                </div>

                <div class="modal-footer gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    {{-- <button type="button" class="btn btn-primary" wire:click="printTransaction">Print
                        Struk</button> --}}
                    <a href="#" id="btnPrintAndroid" class="btn btn-success d-none">
                        <i class="fab fa-android me-1"></i> Print Android
                    </a>
                </div>

            </div>
        </div>
    </div>



</div>
