<x-admin-panel>
  <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-2">
    <div class="mb-3">
      <h1 class="mb-1">Halaman User</h1>
      <p class="fw-medium">You have <span class="text-primary fw-bold">200+</span> Orders, Today</p>
    </div>
    <div class="input-icon-start position-relative mb-3">
      <!-- Button to trigger Tambah User Modal -->
      <div class="input-icon-start position-relative mb-3">
        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tambahUserModal">
          <i class="fa-solid fa-plus"></i> Tambah User
        </button>
      </div>
    </div>
  </div>

  <!-- Tambah User Modal -->
  <div class="modal fade" id="tambahUserModal" tabindex="-1" aria-labelledby="tambahUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{ route('user.store') }}" method="POST">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="tambahUserModalLabel">Tambah User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="nama" class="form-label">Nama</label>
              <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan email">
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="password" class="form-control" id="password"
                placeholder="Masukkan password">
            </div>
            <div class="mb-3">
              <label for="role" class="form-label">Role</label>
              <select class="form-select" required multiple id="pilihrole" name="role[]">
                @foreach ($role as $get)
                  <option value="{{ $get->name }}">{{ $get->name }}</option>
                @endforeach
              </select>
            </div>
            @if (request()->routeIs('karyawan'))
              <div class="mb-3">
                <label for="toko" class="form-label">Akses</label>
                <select class="form-select" multiple id="pilihtoko" name="toko[]">
                  @foreach ($toko as $t)
                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                  @endforeach
                </select>
              </div>
            @endif
          </div>
          <div class="modal-footer gap-2">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  {{-- @dd($role) --}}
  <div class="row">
    <div class="table-responsive">
      <table class="table table-nowrap mb-0">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $key)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $key->name }}</td>
              <td>{{ $key->email }}</td>
              <td>
                @foreach ($key->getRoleNames() as $rname)
                  <span class="badge bg-primary">{{ $rname }}</span>
                @endforeach
              </td>
              <td>
                <div class="d-md-flex d-block">
                  <!-- Edit Button triggers modal -->
                  <button class="btn btn-icon btn-sm btn-info mx-1" data-bs-toggle="modal"
                    data-bs-target="#editUserModal{{ $key->id }}">
                    <i class="fa-regular fa-pen-to-square"></i>
                  </button>
                  <button class="btn btn-icon btn-sm btn-danger mx-1">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </div>
              </td>
            </tr>

            <!-- Edit User Modal -->
            <div class="modal fade" id="editUserModal{{ $key->id }}" tabindex="-1"
              aria-labelledby="editUserModalLabel{{ $key->id }}" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="{{ route('user.update', $key->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                      <h5 class="modal-title" id="editUserModalLabel{{ $key->id }}">Edit User</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="mb-3">
                        <label for="edit-nama-{{ $key->id }}" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="edit-nama-{{ $key->id }}"
                          name="nama" value="{{ $key->name }}" required>
                      </div>
                      <div class="mb-3">
                        <label for="edit-email-{{ $key->id }}" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit-email-{{ $key->id }}"
                          name="email" value="{{ $key->email }}" required>
                      </div>
                      <div class="mb-3">
                        <label for="edit-role-{{ $key->id }}" class="form-label">Role</label>
                        <select class="form-select" multiple id="edit-role-{{ $key->id }}" name="role[]">
                          @foreach ($role as $r)
                            <option value="{{ $r->name }}"
                              {{ in_array($r->name, $key->getRoleNames()->toArray()) ? 'selected' : '' }}>
                              {{ $r->name }}
                            </option>
                          @endforeach
                        </select>
                      </div>
                      @if (request()->routeIs('karyawan'))
                        <div class="mb-3">
                          <label for="edit-toko-{{ $key->id }}" class="form-label">Akses</label>
                          <select class="form-select" multiple id="edit-toko-{{ $key->id }}" name="toko[]">
                            @foreach ($toko as $t)
                              <option value="{{ $t->id }}"
                                {{ isset($key->toko) && in_array($t->name, $key->toko->pluck('name')->toArray()) ? 'selected' : '' }}>
                                {{ $t->name }}
                              </option>
                            @endforeach
                          </select>
                        </div>
                      @endif
                      <div class="mb-3">
                        <label for="edit-password-{{ $key->id }}" class="form-label">Password (Kosongkan jika
                          tidak diubah)</label>
                        <input type="password" class="form-control" id="edit-password-{{ $key->id }}"
                          name="password" placeholder="Masukkan password baru">
                      </div>
                    </div>
                    <div class="modal-footer gap-2">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>


  <script>
    new SlimSelect({
      select: '#pilihrole',
    });
    new SlimSelect({
      select: '#pilihtoko',
    });

    @foreach ($users as $key)
      new SlimSelect({
        select: '#edit-toko-{{ $key->id }}',
      });
      new SlimSelect({
        select: '#edit-role-{{ $key->id }}',
      });
    @endforeach
  </script>
</x-admin-panel>
