<div class="sidebar" id="sidebar">
  <!-- Logo -->
  <div class="sidebar-logo active">
    <a href="index.html" class="logo logo-normal">
      <img src="{{ asset(Session::get('toko.logo')) }}" alt="Img">
    </a>
    <a href="index.html" class="logo logo-white">
      <img src="{{ asset('assets/img/logo-white.svg') }}" alt="Img">
    </a>
    <a href="index.html" class="logo-small">
      <img alt="Img" data-cfsrc="{{ asset('assets/img/logo-small.png') }}"
        style="display:none;visibility:hidden;"><noscript><img src="{{ asset('assets/img/logo-small.png') }}"
          alt="Img"></noscript>
    </a>
    <a id="toggle_btn" href="javascript:void(0);">
      <i data-feather="chevrons-left" class="feather-16"></i>
    </a>
  </div>
  <!-- /Logo -->
  <div class="modern-profile p-3 pb-0">
    <div class="text-center rounded bg-light p-3 mb-4 user-profile">
      <div class="avatar avatar-lg online mb-3">
        <img alt="Img" class="img-fluid rounded-circle"
          data-cfsrc="{{ asset('assets/img/customer/customer15.jpg') }}"
          style="display:none;visibility:hidden;"><noscript><img src="{{ asset('assets/img/customer/customer15.jpg') }}"
            alt="Img" class="img-fluid rounded-circle"></noscript>
      </div>
      <h6 class="fs-14 fw-bold mb-1">Adrian Herman</h6>
      <p class="fs-12 mb-0">System Admin</p>
    </div>
    <div class="sidebar-nav mb-3">
      <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified bg-transparent" role="tablist">
        <li class="nav-item"><a class="nav-link active border-0" href="#">Menu</a></li>
        <li class="nav-item"><a class="nav-link border-0" href="chat.html">Chats</a></li>
        <li class="nav-item"><a class="nav-link border-0" href="email.html">Inbox</a></li>
      </ul>
    </div>
  </div>
  <div class="sidebar-header p-3 pb-0 pt-2">
    <div class="text-center rounded bg-light p-2 mb-4 sidebar-profile d-flex align-items-center">
      <div class="avatar avatar-md onlin">
        <img alt="Img" class="img-fluid rounded-circle"
          data-cfsrc="{{ asset('assets/img/customer/customer15.jpg') }}"
          style="display:none;visibility:hidden;"><noscript><img src="{{ asset('assets/img/customer/customer15.jpg') }}"
            alt="Img" class="img-fluid rounded-circle"></noscript>
      </div>
      <div class="text-start sidebar-profile-info ms-2">
        <h6 class="fs-14 fw-bold mb-1">Adrian Herman</h6>
        <p class="fs-12">System Admin</p>
      </div>
    </div>
    <div class="d-flex align-items-center justify-content-between menu-item mb-3">
      <div>
        <a href="index.html" class="btn btn-sm btn-icon bg-light">
          <i class="ti ti-layout-grid-remove"></i>
        </a>
      </div>
      <div>
        <a href="chat.html" class="btn btn-sm btn-icon bg-light">
          <i class="ti ti-brand-hipchat"></i>
        </a>
      </div>
      <div>
        <a href="email.html" class="btn btn-sm btn-icon bg-light position-relative">
          <i class="ti ti-message"></i>
        </a>
      </div>
      <div class="notification-item">
        <a href="activities.html" class="btn btn-sm btn-icon bg-light position-relative">
          <i class="ti ti-bell"></i>
          <span class="notification-status-dot"></span>
        </a>
      </div>
      <div class="me-0">
        <a href="general-settings.html" class="btn btn-sm btn-icon bg-light">
          <i class="ti ti-settings"></i>
        </a>
      </div>
    </div>
  </div>
  <div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu">
      <ul>
        <li class="submenu-open">
          <h6 class="submenu-hdr">Beranda</h6>
          <ul>
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
              <a href="{{ route('dashboard') }}">
                <i class="ti ti-home fs-16 me-2"></i>
                <span>Dashboard</span>
              </a>
            </li>
          </ul>
        </li>
        <li class="submenu-open">
          <h6 class="submenu-hdr">Manajemen Inventaris</h6>
          <ul>
            <li class="{{ request()->routeIs('kategori.index') ? 'active' : '' }}">
              <a href="{{ route('kategori.index') }}">
                <i class="ti ti-list-details fs-16 me-2"></i>
                <span>Kategori</span>
              </a>
            </li>
            <li class="{{ request()->routeIs('produk.index') ? 'active' : '' }}">
              <a href="{{ route('produk.index') }}">
                <i class="ti ti-box fs-16 me-2"></i>
                <span>Produk</span>
              </a>
            </li>
            <li class="{{ request()->routeIs('meja.index') ? 'active' : '' }}">
              <a href="{{ route('meja.index') }}">
                <i class="ti ti-layout-grid fs-16 me-2"></i>
                <span>Meja</span>
              </a>
            </li>
          </ul>
        </li>
        <li class="submenu-open">
          <h6 class="submenu-hdr">Manajemen Produk</h6>
          <ul>
            <li class="{{ request()->routeIs('produk.stok') ? 'active' : '' }}">
              <a href="{{ route('produk.stok') }}">
                <i class="ti ti-stack-3 fs-16 me-2"></i>
                <span>Stok & Harga</span>
              </a>
            </li>
          </ul>
        </li>
        <li class="submenu-open">
          <h6 class="submenu-hdr">Laporan</h6>
          <ul>
            <li class="{{ request()->routeIs('laporan.transaksi') ? 'active' : '' }}">
              <a href="{{ route('laporan.transaksi') }}">
                <i class="ti ti-file-invoice fs-16 me-2"></i>
                <span>Transaksi</span>
              </a>
            </li>
            <li class="{{ request()->routeIs('laporan.shift') ? 'active' : '' }}">
              <a href="{{ route('laporan.shift') }}">
                <i class="ti ti-chart-bar fs-16 me-2"></i>
                <span>Rekap Shift</span>
              </a>
            </li>
            <li class="{{ request()->routeIs('kas.index') ? 'active' : '' }}">
              <a href="{{ route('kas.index') }}">
                <i class="ti ti-wallet fs-16 me-2"></i>
                <span>Kas</span>
              </a>
            </li>
          </ul>
        </li>
        @if (Auth::user()->hasRole(['core', 'admin']))
            <li class="submenu-open">
              <h6 class="submenu-hdr">Pengaturan Sistem</h6>
              <ul>
                {{-- <li class="{{ request()->routeIs('permission.index') ? 'active' : '' }}">
                  <a href="{{ route('permission.index') }}">
                    <i class="ti ti-lock-access fs-16 me-2"></i>
                    <span>Permission</span>
                  </a>
                </li> --}}
                @if (Auth::user()->hasRole('core'))
                    <li class="{{ request()->routeIs('role.index') ? 'active' : '' }}">
                      <a href="{{ route('role.index') }}">
                        <i class="ti ti-user-shield fs-16 me-2"></i>
                        <span>Role</span>
                      </a>
                    </li>
                @endif
                <li class="{{ request()->routeIs('toko.index') ? 'active' : '' }}">
                  <a href="{{ route('toko.index') }}">
                    <i class="ti ti-building-store fs-16 me-2"></i>
                    <span>Toko</span>
                  </a>
                </li>

                <li>
                  <a href="{{ route('user.index') }}">
                    <i class="ti ti-users fs-16 me-2"></i>
                    <span>Admin</span>
                  </a>
                </li>
                <li>
                  <a href="{{ route('karyawan') }}">
                    <i class="ti ti-user-plus fs-16 me-2"></i>
                    <span>Kasir & operator</span>
                  </a>
                </li>
              </ul>
            </li>
        @endif
      </ul>
    </div>
  </div>
</div>
