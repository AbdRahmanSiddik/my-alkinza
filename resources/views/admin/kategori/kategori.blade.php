<x-admin-panel>
  <div class="page-header">
    <div class="add-item d-flex">
      <div class="page-title">
        <h4 class="fw-bold">Data Kategori</h4>
        <h6>Manage Kategori Anda</h6>
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
      <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahKategori">
        <i class="ti ti-circle-plus me-1"></i>
        Tambah Kategori
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
              <th>Gambar</th>
              <th>Nama Kategori</th>
              <th class="no-sort"></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($kategoris as $index => $item)
              <tr>
                <td>{{ $index + 1 }}.</td>
                <td>
                  <a href="{{ asset($item->icon) }}" class="avatar avatar-md me-2">
                    <img src="{{ asset($item->icon) }}" alt="Logo Kategori">
                  </a>
                </td>
                <td>{{ $item->name }}</td>
                <td class="action-table-data">
                  <div class="edit-delete-action">
                    <a class="me-2 p-2" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top"
                      title="Edit Kategori" data-modal-target="#editKategori{{ $item->token_kategori }}">
                      <i data-feather="edit" class="feather-edit text-dark"></i>
                    </a>
                    <a href="javascript:void(0);" class="p-2 text-danger" data-bs-toggle="tooltip"
                      data-bs-placement="top" title="Hapus Kategori"
                      onclick="confirmDelete('{{ route('kategori.destroy', $item->token_kategori) }}', '{{ addslashes($item->name) }}')">
                      <i data-feather="trash-2" class="feather-trash-2"></i>
                    </a>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center">Tidak ada data kategori</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- /product list -->

  @include('admin.kategori.form-create')
  @include('admin.kategori.form-edit')

</x-admin-panel>
