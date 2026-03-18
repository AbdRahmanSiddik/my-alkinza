<x-admin-panel>
  <div class="page-header">
    <div class="add-item d-flex">
      <div class="page-title">
        <h4 class="fw-bold">Data Kas</h4>
        <h6>Manage Kas Anda</h6>
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
        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
            class="ti ti-chevron-up"></i></a>
      </li>
    </ul>
    <div class="page-btn">
      <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahKas">
        <i class="ti ti-circle-plus me-1"></i>
        Tambah Data
      </a>
    </div>
  </div>

  <!-- /product list -->
  <div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
      <div class="search-set">
        <div class="search-input">
          <span class="btn-searchset">
            <i class="ti ti-search fs-14 feather-search"></i>
          </span>
        </div>
      </div>
      <div class="d-flex align-items-center gap-2 ms-auto">
        <button type="button" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1" disabled>
          <i class="ti ti-trending-up text-success"></i>
          Rp. {{ number_format($pemasukan, 0, ',', '.') }}
        </button>
        <button type="button" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1" disabled>
          <i class="ti ti-trending-down text-danger"></i>
          Rp. {{ number_format($pengeluaran, 0, ',', '.') }}
        </button>
        <button type="button" class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1" disabled>
          <i class="ti ti-wallet text-primary"></i>
          Saldo Kas: Rp{{ number_format($saldo, 0, ',', '.') }}
        </button>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table datatable">
          <thead class="thead-light">
            <tr>
              <th>No.</th>
              <th>Nama Kas</th>
              <th>Jenis Kas</th>
              <th>Tanggal</th>
              <th>Status</th>
              <th class="no-sort"></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($kas as $index => $item)
              <tr>
                <td>{{ $index + 1 }}.</td>
                <td>{{ $item->nama }}</td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <i class="ti {{ $item->jenis == 'pengeluaran' ? 'ti-trending-down text-danger' : 'ti-trending-up text-success' }}"></i>
                    <div>
                      <div>{{ ucfirst($item->jenis) }}</div>
                      <div class="fw-semibold">@rupiah($item->jumlah)</div>
                    </div>
                  </div>
                </td>
                <td>
                    <div>{{ $item->kasir?->name }}</div>
                    <div>{{ $item->tanggal }}</div>
                </td>
                <td>
                    @if ($item->status === 'diajukan')
                        <span class="badge bg-warning">Diajukan</span>
                    @elseif ($item->status === 'selesai')
                        <span class="badge bg-success">Selesai</span>
                    @else
                        <span class="badge bg-danger">Ditolak</span>
                    @endif
                </td>
                <td class="action-table-data">
                  <div class="edit-delete-action">
                    <a class="me-2 p-2 text-info" href="javascript:void(0);" data-bs-toggle="tooltip"
                      data-bs-placement="top" title="Detail Kas" data-modal-target="#detailKas{{ $item->token_kas }}">
                      <i data-feather="info" class="feather-info text-dark"></i>
                    </a>
                    @if ($item->status != 'diajukan')
                        <a class="me-2 p-2" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top"
                          title="Edit Kas" data-modal-target="#editKas{{ $item->token_kas }}">
                          <i data-feather="edit" class="feather-edit text-dark"></i>
                        </a>
                        <a href="javascript:void(0);" class="p-2 text-danger" data-bs-toggle="tooltip"
                          data-bs-placement="top" title="Hapus Kas"
                          onclick="confirmDelete('{{ route('kas.destroy', $item->token_kas) }}', '{{ addslashes($item->name) }}')">
                          <i data-feather="trash-2" class="feather-trash-2"></i>
                        </a>
                    @endif
                  </div>
                </td>
              </tr>

              <div class="modal fade modal-sweet" id="detailKas{{ $item->token_kas }}" tabindex="-1"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 700px;">
                  <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header border-0">
                      <h5 class="modal-title fw-bold">Detail Kas</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="mb-3 d-flex">
                            <div class="fw-semibold text-secondary" style="width: 120px;">Nama</div>
                            <div>: {{ $item->nama }}</div>
                          </div>
                          <div class="mb-3 d-flex">
                            <div class="fw-semibold text-secondary" style="width: 120px;">Jenis</div>
                            <div>:
                              @if ($item->jenis === 'pemasukan')
                                <span class="badge bg-primary">{{ ucfirst($item->jenis) }}</span>
                              @else
                                <span class="badge bg-danger">{{ ucfirst($item->jenis) }}</span>
                              @endif
                            </div>
                          </div>
                          <div class="mb-3 d-flex">
                            <div class="fw-semibold text-secondary" style="width: 120px;">Nominal</div>
                            <div>: Rp {{ number_format($item->jumlah, 0, ',', '.') }}</div>
                          </div>
                          <div class="mb-3 d-flex">
                            <div class="fw-semibold text-secondary" style="width: 120px;">Tanggal</div>
                            <div>: {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</div>
                          </div>
                          <div class="mb-2 d-flex">
                            <div class="fw-semibold text-secondary" style="width: 120px;">Keterangan</div>
                            <div class="flex-grow-1">:</div>
                          </div>
                          <div class="bg-light px-3 py-2 rounded mt-1" style="min-height: 100px;">
                            {!! $item->keterangan ?? '<em class="text-muted">Tidak ada keterangan</em>' !!}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer border-0 gap-2 d-flex justify-content-end">
                      <button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Tutup</button>

                      @if ($item->status == 'diajukan')
                        <a href="{{ route('kas.approve', $item->token_kas) }}" class="btn btn-success">Setujui</a>
                        <a href="{{ route('kas.reject', $item->token_kas) }}" class="btn btn-danger">Tolak</a>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            @empty
              <tr>
                <td colspan="4" class="text-center">Tidak ada data Kas</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- /product list -->

  @include('admin.kas.form-create')
  @include('admin.kas.form-edit')

</x-admin-panel>
