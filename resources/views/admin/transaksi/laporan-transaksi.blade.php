<x-admin-panel>
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Laporan Transaksi</h4>
                <h6>Data Transaksi yang Sudah Diselesaikan</h6>
            </div>
        </div>
        <ul class="table-top-head">
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf">
                    <img src="{{ asset('assets/img/icons/pdf.svg') }}" alt="img">
                </a>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel">
                    <img src="{{ asset('assets/img/icons/excel.svg') }}" alt="img">
                </a>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header">
                    <i class="ti ti-chevron-up"></i>
                </a>
            </li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
            <div class="search-set">
                <div class="search-input">
                    <span class="btn-searchset">
                        <i class="ti ti-search fs-14 feather-search"></i>
                    </span>
                </div>
            </div>
            <form method="GET" class="d-flex align-items-center gap-2 ms-auto me-2">
                <select name="searchKasir" id="searchKasir" class="form-control">
                    <option value="">Pilih Kasir</option>
                    @foreach ($kasir as $k)
                        <option value="{{ $k->id }}" {{ request('searchKasir') == $k->id ? 'selected' : '' }}>
                            {{ $k->name }}
                        </option>
                    @endforeach
                </select>
                <input type="date" id="searchDate" name="searchDate" class="form-control form-control"
                    value="{{ request('searchDate', now()->format('Y-m-d')) }}">
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
            <div>
                <a href="{{ route('laporan.transaksi') }}" class="btn btn-secondary">
                    <i class="ti ti-refresh-cw"></i> Refresh
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table datatable">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Transaksi</th>
                            <th>Kuantitas</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th class="no-sort"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksi as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->nama_pelanggan ?? '-' }} <br>
                                    {{ $item->kode_transaksi }}</td>
                                <td>{{ $item->kuantitas }}</td>
                                <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                <td>
                                    @if ($item->status == 'selesai')
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif ($item->status == 'keranjang')
                                        <span class="badge bg-info">Keranjang</span>
                                    @elseif ($item->status == 'menanti')
                                        <span class="badge bg-warning">Menanti</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($item->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        {{ $item->kasir->name }}
                                    </div>
                                    <div>
                                        {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y, H:i') }}
                                    </div>
                                </td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 p-2 text-info" href="javascript:void(0);" data-bs-toggle="modal"
                                            data-bs-target="#detailTransaksi{{ $item->id }}" data-bs-placement="top"
                                            title="Detail Transaksi">
                                            <i data-feather="info" class="feather-info text-dark"></i>
                                        </a>
                                        @if ($item->status == 'menanti')
                                            <a class="me-2 p-2 text-warning" href="javascript:void(0);"
                                                data-bs-toggle="modal"
                                                data-bs-target="#pembatalanTransaksi{{ $item->id }}"
                                                data-bs-placement="top" title="Pengajuan Pembatalan">
                                                <i data-feather="x-circle" class="feather-x-circle text-dark"></i>
                                            </a>

                                            <!-- Modal Pengajuan Pembatalan Transaksi -->
                                            <div class="modal fade" id="pembatalanTransaksi{{ $item->id }}"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content border-0 shadow rounded-4">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Pengajuan Pembatalan -
                                                                {{ $item->kode_transaksi }}</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Transaksi ini memiliki pengajuan pembatalan. Pilih aksi
                                                                berikut:</p>
                                                        </div>
                                                        <div class="modal-footer d-flex gap-2">
                                                            <button class="btn btn-secondary me-auto"
                                                                data-bs-dismiss="modal">Tutup</button>

                                                            <form action="{{ route('transaksi.pembatalan.update', $item->id) }}" method="POST" class="d-flex gap-2">
                                                                @csrf
                                                                <button type="submit" name="action" value="reject" class="btn btn-danger">Tolak</button>
                                                                <button type="submit" name="action" value="accept" class="btn btn-success">Terima</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Detail Transaksi -->
                            <div class="modal fade" id="detailTransaksi{{ $item->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content border-0 shadow rounded-4">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Transaksi - {{ $item->kode_transaksi }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-2"><strong>Nama:</strong>
                                                {{ $item->nama_pelanggan ?? '-' }}</div>
                                            <div class="mb-2"><strong>No HP:</strong> {{ $item->no_telepon ?? '-' }}
                                            </div>
                                            <div class="mb-2"><strong>Jenis:</strong>
                                                {{ ucfirst($item->jenis_transaksi) }}</div>
                                            <div class="mb-2"><strong>Total:</strong> Rp
                                                {{ number_format($item->total_harga, 0, ',', '.') }}</div>
                                            <div class="mb-3"><strong>Diskon:</strong> {{ $item->diskon }}%</div>
                                            <h6 class="fw-bold mt-4">Produk Dibeli</h6>
                                            <ul class="list-group">
                                                @foreach ($item->produkPivot as $pivot)
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-start">
                                                        <div class="ms-2 me-auto">
                                                            <div class="fw-semibold">{{ $pivot->produk->name }}</div>
                                                            <div class="text-muted small">
                                                                @rupiah($pivot->produk->harga)/{{ ucfirst($pivot->produk->satuan) }}
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            @if ($pivot->produk->satuan == 'gram')
                                                                <div>
                                                                    {{ number_format($pivot->kuantitas, 0, ',', '.') }}
                                                                    gram
                                                                </div>
                                                            @else
                                                                <div>
                                                                    {{ $pivot->kuantitas }}
                                                                </div>
                                                            @endif
                                                            <div class="fw-semibold">
                                                                @rupiah($pivot->subtotal)
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            {{-- <tr>
                                <td colspan="7" class="text-center">Tidak ada transaksi diselesaikan.</td>
                            </tr> --}}
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-panel>
