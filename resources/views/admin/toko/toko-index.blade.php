<x-admin-panel>
  <div class="page-header">
    <div class="add-item d-flex">
      <div class="page-title">
        <h4 class="fw-bold">Data Toko</h4>
        <h6>Manage Toko Anda</h6>
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
      <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahToko">
        <i class="ti ti-circle-plus me-1"></i>
        Tambah Toko
      </a>
    </div>
  </div>

  <!-- /product list -->
  <div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
      <div class="search-set">
        <div class="search-input">
          <span class="btn-searchset"><i class="ti ti-search fs-14 feather-search"></i></span>
        </div>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table datatable">
          <thead class="thead-light">
            <tr>
              <th>No.</th>
              <th>Logo</th>
              <th>Kode Toko</th>
              <th>Nama Toko</th>
              <th class="no-sort"></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($tokos as $index => $item)
              <tr>
                <td>{{ $index + 1 }}.</td>
                <td>
                  <a href="{{ asset($item->logo) }}" class="avatar avatar-md me-2">
                    <img src="{{ asset($item->logo) }}" alt="Logo Toko">
                  </a>
                </td>
                <td>{{ $item->kode_toko }}</td>
                <td>{{ $item->name ?? '-' }}</td>
                <td class="action-table-data">
                  <div class="edit-delete-action">
                    <a class="me-2 p-2 text-info" href="javascript:void(0);" data-bs-toggle="tooltip"
                      data-bs-placement="top" title="Detail Toko"
                      data-modal-target="#detailToko{{ $item->token_toko }}">
                      <i data-feather="info" class="feather-info text-dark"></i>
                    </a>
                    <a class="me-2 p-2" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top"
                      title="Edit Toko" data-modal-target="#editToko{{ $item->token_toko }}">
                      <i data-feather="edit" class="feather-edit text-dark"></i>
                    </a>
                    <a href="javascript:void(0);" class="p-2 text-danger" data-bs-toggle="tooltip"
                      data-bs-placement="top" title="Hapus Toko"
                      onclick="confirmDelete('{{ route('toko.destroy', $item->token_toko) }}', '{{ addslashes($item->name) }}')">
                      <i data-feather="trash-2" class="feather-trash-2"></i>
                    </a>
                  </div>
                </td>
              </tr>

              <!-- Modal Detail Toko -->
              <div class="modal fade modal-sweet" id="detailToko{{ $item->token_toko }}" tabindex="-1"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 700px;">
                  <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header border-0">
                      <h5 class="modal-title fw-bold">Detail Toko</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                      <div class="row">
                        <div class="col-md-5 text-center mb-3 mb-md-0">
                          <div class="w-100 border rounded overflow-hidden shadow-sm"
                            style="background: #f8f9fa; height: 250px; display: flex; align-items: center; justify-content: center;">
                            <img src="{{ asset($item->logo ?? 'assets/uploadImg/upload.jpg') }}" alt="Logo Toko"
                              class="img-fluid" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                          </div>
                        </div>
                        <div class="col-md-7">
                          <h4 class="fw-semibold mb-2"><strong>Toko {{ $item->name }}</strong></h4>

                          <div class="mb-2 d-flex">
                            <div class="fw-semibold text-secondary" style="width: 80px;">Kode</div>
                            <div>: {{ $item->kode_toko }}</div>
                          </div>
                          <div class="mb-2 d-flex">
                            <div class="fw-semibold text-secondary" style="width: 80px;">Alamat</div>
                            <div>: {{ $item->addres ?? '-' }}</div>
                          </div>
                          <div class="mb-2 d-flex">
                            <div class="fw-semibold text-secondary" style="width: 80px;">Deskripsi</div>
                            <div class="flex-grow-1">:</div>
                          </div>
                          <div class="bg-light px-3 py-2 rounded mt-1" style="min-height: 100px;">
                            {!! $item->deskripsi ?? '<em class="text-muted">Tidak ada deskripsi</em>' !!}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer border-0">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                  </div>
                </div>
              </div>
            @empty
              <tr>
                <td colspan="4" class="text-center">Tidak ada data toko</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- /product list -->

  @include('admin.toko.form-create')
  @include('admin.toko.form-edit')

</x-admin-panel>
