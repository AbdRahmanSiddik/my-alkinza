<div class="sidebar sidebar-horizontal" id="horizontal-menu">
  <div id="sidebar-menu-3" class="sidebar-menu">
    <div class="main-menu">
      <ul class="nav-menu">

        {{-- Beranda --}}
        <li class="submenu">
          <a href="javascript:void(0);">
            <i class="ti ti-home fs-16 me-2"></i>
            <span>Beranda</span>
            <span class="menu-arrow"></span>
          </a>
          <ul>
            <li>
              <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                Dashboard
              </a>
            </li>
          </ul>
        </li>

        {{-- Manajemen Inventaris --}}
        <li class="submenu">
          <a href="javascript:void(0);">
            <i class="ti ti-archive fs-16 me-2"></i>
            <span>Manajemen Inventaris</span>
            <span class="menu-arrow"></span>
          </a>
          <ul>
            <li>
              <a href="{{ route('kategori.index') }}"
                class="{{ request()->routeIs('kategori.index') ? 'active' : '' }}">
                Kategori
              </a>
            </li>
            <li>
              <a href="{{ route('produk.index') }}" class="{{ request()->routeIs('produk.index') ? 'active' : '' }}">
                Produk
              </a>
            </li>
          </ul>
        </li>

        {{-- Laporan --}}
        <li class="submenu">
          <a href="javascript:void(0);">
            <i class="ti ti-file-invoice fs-16 me-2"></i>
            <span>Laporan</span>
            <span class="menu-arrow"></span>
          </a>
          <ul>
            <li>
              <a href="{{ route('laporan.transaksi') }}" class="{{ request()->routeIs('laporan.transaksi') ? 'active' : '' }}">
                Transaksi
              </a>
            </li>
            <li>
              <a href="{{ route('kas.index') }}" class="{{ request()->routeIs('kas.index') ? 'active' : '' }}">
                Kas
              </a>
            </li>
          </ul>
        </li>

        {{-- Pengaturan Sistem --}}
        <li class="submenu">
          <a href="javascript:void(0);">
            <i class="ti ti-settings fs-16 me-2"></i>
            <span>Pengaturan Sistem</span>
            <span class="menu-arrow"></span>
          </a>
          <ul>
            <li>
              <a href="{{ route('permission.index') }}"
                class="{{ request()->routeIs('permission.index') ? 'active' : '' }}">
                Permission
              </a>
            </li>
            <li>
              <a href="{{ route('role.index') }}" class="{{ request()->routeIs('role.index') ? 'active' : '' }}">
                Role
              </a>
            </li>
            <li>
              <a href="{{ route('toko.index') }}" class="{{ request()->routeIs('toko.index') ? 'active' : '' }}">
                Toko
              </a>
            </li>
            <li class="submenu">
              <a href="javascript:void(0);">
                <span>Pengguna</span>
                <span class="menu-arrow"></span>
              </a>
              <ul>
                @foreach (\Spatie\Permission\Models\Role::get() as $item)
                  <li>
                    <a href="{{ route('user.index', ['role' => $item->name]) }}">
                      {{ ucfirst($item->name) }}
                    </a>
                  </li>
                @endforeach
                <li>
                  <a href="/user">Tambah User</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</div>
