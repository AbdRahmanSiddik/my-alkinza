<div class="two-col-sidebar" id="two-col-sidebar">
  <div class="sidebar sidebar-twocol">
    <div class="twocol-mini">
      <div class="sidebar-left slimscroll">
        <div class="nav flex-column align-items-center nav-pills" id="sidebar-tabs" role="tablist"
          aria-orientation="vertical">
          <!-- Dashboard -->
          <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" data-bs-toggle="tab"
            data-bs-target="#tab-dashboard" title="Dashboard">
            <i class="ti ti-home fs-18"></i>
          </a>
          <!-- Manajemen Inventaris -->
          <a class="nav-link {{ request()->is('kategori*') || request()->is('produk*') ? 'active' : '' }}"
            data-bs-toggle="tab" data-bs-target="#tab-inventaris" title="Inventaris">
            <i class="ti ti-box fs-18"></i>
          </a>
          <!-- Manajemen Inventaris -->
          <a class="nav-link {{ request()->is('kategori*') || request()->is('produk*') ? 'active' : '' }}"
            data-bs-toggle="tab" data-bs-target="#tab-produk" title="Produk">
            <i class="ti ti-box fs-18"></i>
          </a>
          <!-- Keuangan -->
          <a class="nav-link {{ request()->is('kas*') ? 'active' : '' }}" data-bs-toggle="tab"
            data-bs-target="#tab-keuangan" title="Laporan">
            <i class="ti ti-file-invoice fs-18"></i>
          </a>
          <!-- Pengaturan -->
          <a class="nav-link {{ request()->is('permission*') || request()->is('role*') || request()->is('toko*') ? 'active' : '' }}"
            data-bs-toggle="tab" data-bs-target="#tab-pengaturan" title="Pengaturan Sistem">
            <i class="ti ti-settings fs-18"></i>
          </a>
        </div>
      </div>
    </div>

    <!-- Sidebar Kanan (Konten Tab) -->
    <div class="sidebar-right">
      <!-- Logo -->
      <div class="sidebar-logo">
        <a href="index.html" class="logo logo-normal">
          <img src="{{ asset('assets/img/logo.svg') }}" alt="Img">
        </a>
        <a href="index.html" class="logo logo-white">
          <img src="{{ asset('assets/img/logo-white.svg') }}" alt="Img">
        </a>
        <a href="index.html" class="logo-small">
          <img src="{{ asset('assets/img/logo-small.png') }}" alt="Img">
        </a>
      </div>
      <!-- /Logo -->

      <div class="sidebar-scroll">
        <div class="text-center rounded bg-light p-3 mb-3 border">
          <div class="avatar avatar-lg online mb-3">
            <img src="{{ asset('assets/img/customer/customer15.jpg') }}" alt="Img"
              class="img-fluid rounded-circle">
          </div>
          <h6 class="fs-14 fw-bold mb-1">Adrian Herman</h6>
          <p class="fs-12 mb-0">System Admin</p>
        </div>

        <div class="tab-content" id="v-pills-tabContent">
          <!-- Tab Dashboard -->
          <div class="tab-pane fade {{ request()->routeIs('dashboard') ? 'show active' : '' }}" id="welcome">
            <ul>
              <li class="menu-title"><span>BERANDA</span></li>
              <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                  <i class="ti ti-home fs-16 me-2"></i> Dashboard</a></li>
            </ul>
          </div>

          <div class="tab-content" id="v-pills-tabContent">
            <!-- Dashboard -->
            <div class="tab-pane fade {{ request()->routeIs('dashboard') ? 'show active' : '' }}" id="tab-dashboard">
              <ul>
                <li class="menu-title"><span>Beranda</span></li>
                <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="ti ti-home me-2"></i> Dashboard</a></li>
              </ul>
            </div>

            <!-- Inventaris -->
            <div
              class="tab-pane fade {{ request()->is('kategori*') || request()->is('produk*') ? 'show active' : '' }}"
              id="tab-inventaris">
              <ul>
                <li class="menu-title"><span>Manajemen Inventaris</span></li>
                <li><a href="{{ route('kategori.index') }}"
                    class="{{ request()->routeIs('kategori.index') ? 'active' : '' }}">
                    <i class="ti ti-list-details me-2"></i> Kategori</a></li>
                <li><a href="{{ route('produk.index') }}"
                    class="{{ request()->routeIs('produk.index') ? 'active' : '' }}">
                    <i class="ti ti-box me-2"></i> Produk</a></li>
              </ul>
            </div>
            <!-- Produk -->
            <div
              class="tab-pane fade {{ request()->is('kategori*') || request()->is('produk*') ? 'show active' : '' }}"
              id="tab-produk">
              <ul>
                <li class="menu-title"><span>Manajemen Produk</span></li>
                <li><a href="{{ route('kategori.index') }}"
                    class="{{ request()->routeIs('kategori.index') ? 'active' : '' }}">
                    <i class="ti ti-list-details me-2"></i> Stok</a></li>
                <li><a href="{{ route('produk.index') }}"
                    class="{{ request()->routeIs('produk.index') ? 'active' : '' }}">
                    <i class="ti ti-box me-2"></i> Harga</a></li>
              </ul>
            </div>

            <!-- Laporan -->
            <div
              class="tab-pane fade {{ request()->routeIs('laporan.transaksi') || request()->routeIs('kas.index') ? 'show active' : '' }}"
              id="tab-keuangan">
              <ul>
                <li class="menu-title"><span>Laporan</span></li>
                <li>
                  <a href="{{ route('laporan.transaksi') }}"
                    class="{{ request()->routeIs('laporan.transaksi') ? 'active' : '' }}">
                    <i class="ti ti-file-invoice me-2"></i> Transaksi
                  </a>
                </li>
                <li>
                  <a href="{{ route('kas.index') }}" class="{{ request()->routeIs('kas.index') ? 'active' : '' }}">
                    <i class="ti ti-wallet me-2"></i> Kas
                  </a>
                </li>
              </ul>
            </div>

            <!-- Pengaturan -->
            <div
              class="tab-pane fade {{ request()->is('permission*') || request()->is('role*') || request()->is('toko*') ? 'show active' : '' }}"
              id="tab-pengaturan">
              <ul>
                <li class="menu-title"><span>Pengaturan Sistem</span></li>
                <li><a href="{{ route('permission.index') }}"
                    class="{{ request()->routeIs('permission.index') ? 'active' : '' }}">
                    <i class="ti ti-lock-access me-2"></i> Permission</a></li>
                <li><a href="{{ route('role.index') }}"
                    class="{{ request()->routeIs('role.index') ? 'active' : '' }}">
                    <i class="ti ti-user-shield me-2"></i> Role</a></li>
                <li><a href="{{ route('toko.index') }}"
                    class="{{ request()->routeIs('toko.index') ? 'active' : '' }}">
                    <i class="ti ti-building-store me-2"></i> Toko</a></li>
                <ul>
                  <li class="submenu submenu-two">
                    <a href="javascript:void(0);">
                      <i class="ti ti-users fs-16 me-2"></i> Pengguna
                      <span class="menu-arrow inside-submenu"></span>
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
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
