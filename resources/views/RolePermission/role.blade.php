<x-admin-panel>
  <!-- Header -->
  <div class="page-header">
    <div class="add-item d-flex">
      <div class="page-title">
        <h4 class="fw-bold">Data Role</h4>
        <h6>Manage Data Role</h6>
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
      <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRole">
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
              <th>Nama Role</th>
              <th>Jumlah User</th>
              {{-- <th>Permissions</th> --}}
              <th class="no-sort"></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($roles as $index => $role)
              <tr>
                <td>{{ $index + 1 }}.</td>
                <td>{{ $role->name }}</td>
                <td>{{ $role->users->count() }}</td>
                {{-- <td>
                  @foreach ($role->permissions as $perm)
                    <span class="badge bg-primary">{{ $perm->name }}</span>
                  @endforeach
                </td> --}}
                <td class="action-table-data">
                  <div class="edit-delete-action d-flex">
                    <!-- Tombol Edit -->
                    <a href="javascript:void(0);" class="me-2 p-2" data-bs-toggle="tooltip" data-bs-placement="top"
                      title="Edit Role" data-modal-target="#editRole{{ $role->id }}">
                      <i data-feather="edit" class="feather-edit text-dark"></i>
                    </a>

                    <!-- Tombol Hapus -->
                    <a href="javascript:void(0);" class="p-2 text-danger" data-bs-toggle="tooltip"
                      data-bs-placement="top" title="Hapus Role"
                      onclick="confirmDelete('{{ route('role.destroy', $role) }}', '{{ addslashes($role->name) }}')">
                      <i data-feather="trash-2" class="feather-trash-2"></i>
                    </a>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center">Tidak ada data Role</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- /Table Card -->

  <div class="modal fade" id="createRole" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div class="page-title">
            <h4>Tambah Role</h4>
          </div>
          <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>

        <form action="{{ route('role.store') }}" method="POST">
          @csrf
          <div class="modal-body">
            <div class="mb-3">
              <label for="name" class="form-label">Nama Role</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama role"
                value="{{ old('name') }}" required>
            </div>

            {{-- <div class="mb-3">
              <label for="permissions" class="form-label">Pilih Permission</label>
              <select class="form-select" multiple id="pilihrole" name="permissions[]">
                @foreach ($permissions as $perm)
                  <option value="{{ $perm->id }}">{{ $perm->name }}</option>
                @endforeach
              </select>
            </div> --}}
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  @foreach ($roles as $role)
    <div class="modal fade" id="editRole{{ $role->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <div class="page-title">
              <h4>Edit Role</h4>
            </div>
            <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal">
              <span>&times;</span>
            </button>
          </div>

          <form action="{{ route('role.update', $role) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
              <div class="mb-3">
                <label for="name{{ $role->id }}" class="form-label">Nama Role</label>
                <input type="text" class="form-control" id="name{{ $role->id }}" name="name"
                  value="{{ old('name', $role->name) }}" placeholder="Masukkan nama role" required>
              </div>

              {{-- <div class="mb-3">
                <label for="permissions{{ $role->id }}" class="form-label">Pilih Permission</label>
                <select class="form-select" multiple id="permissions{{ $role->id }}" name="permissions[]">
                  @foreach ($permissions as $perm)
                    <option value="{{ $perm->id }}"
                      {{ $role->permissions->contains($perm->id) ? 'selected' : '' }}>
                      {{ $perm->name }}
                    </option>
                  @endforeach
                </select>
              </div> --}}
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

  <script>
    new SlimSelect({
      select: '#pilihrole'
    });

    @foreach ($roles as $role)
      new SlimSelect({
        select: '#permissions{{ $role->id }}'
      });
    @endforeach
  </script>
</x-admin-panel>
