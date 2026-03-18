<x-admin-panel>
  <!-- Header -->
  <div class="page-header">
    <div class="add-item d-flex">
      <div class="page-title">
        <h4 class="fw-bold">Data Permission</h4>
        <h6>Manage Data Permission</h6>
      </div>
    </div>
    <ul class="table-top-head">
      <li>
        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf">
          <img src="{{ asset('assets/img/icons/pdf.svg') }}" alt="pdf icon">
        </a>
      </li>
      <li>
        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel">
          <img src="{{ asset('assets/img/icons/excel.svg') }}" alt="excel icon">
        </a>
      </li>
      <li>
        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header">
          <i class="ti ti-chevron-up"></i>
        </a>
      </li>
    </ul>
    <div class="page-btn">
      <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahPermission">
        <i class="ti ti-circle-plus me-1"></i>
        Tambah Data
      </a>
    </div>
  </div>
  <!-- /Header -->

  <!-- Table Card -->
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
              <th>Nama Permission</th>
              <th class="no-sort"></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($permissions as $index => $item)
              <tr>
                <td>{{ $index + 1 }}.</td>
                <td>{{ $item->name }}</td>
                <td class="action-table-data">
                  <div class="edit-delete-action d-flex">
                    <!-- Tombol Edit -->
                    <a href="javascript:void(0);" class="me-2 p-2" data-bs-toggle="tooltip" data-bs-placement="top"
                      title="Edit Permission" data-modal-target="#editPermission{{ $item->id }}">
                      <i data-feather="edit" class="feather-edit text-dark"></i>
                    </a>

                    <!-- Tombol Hapus -->
                    <a href="javascript:void(0);" class="p-2 text-danger" data-bs-toggle="tooltip"
                      data-bs-placement="top" title="Hapus Permission"
                      onclick="confirmDelete('{{ route('permission.destroy', $item) }}', '{{ addslashes($item->name) }}')">
                      <i data-feather="trash-2" class="feather-trash-2"></i>
                    </a>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="3" class="text-center">Tidak ada data Permission</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- /Table Card -->

  <div class="modal fade" id="tambahPermission" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div class="page-title">
            <h4>Tambah Permission</h4>
          </div>
          <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>

        <form action="{{ route('permission.store') }}" method="POST">
          @csrf
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Nama Permission <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control" placeholder="Masukkan nama permission"
                value="{{ old('name') }}" required>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  @foreach ($permissions as $permission)
    <div class="modal fade" id="editPermission{{ $permission->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <div class="page-title">
              <h4>Edit Permission</h4>
            </div>
            <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal">
              <span>&times;</span>
            </button>
          </div>

          <form action="{{ route('permission.update', $permission) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Nama Permission <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control"
                  value="{{ old('name', $permission->name) }}" placeholder="Masukkan nama permission" required>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endforeach
</x-admin-panel>
