<div class="header">
  <div class="main-header">
    <!-- Logo -->
    <div class="header-left active">
      <a href="{{ route('dashboard') }}" class="logo logo-normal">
        <img src="{{ asset(Session::get('toko.logo')) }}" alt="Img" height="50px">
      </a>
      <a href="{{ route('dashboard') }}" class="logo logo-white">
        <img src="{{ asset('assets/img/logo-white.svg') }}" alt="Img">
      </a>
      <a href="{{ route('dashboard') }}" class="logo-small">
        <script type="text/javascript" style="display:none">
          //<![CDATA[
          window.__mirage2 = {
            petok: "ByM93qs4xh6f1elSsAsYSuW_3ycSS4p6ghGgCyg3dsE-1800-0.0.1.1"
          };
          //]]>
        </script>
        <script type="text/javascript" src="{{ asset('assets/cdn-cgi/scripts/04b3eb47/cloudflare-static/mirage2.min.js') }}">
        </script>
        <img alt="Img" data-cfsrc="{{ asset('assets/img/logo-small.png') }}"
          style="display:none;visibility:hidden;"><noscript><img src="{{ asset('assets/img/logo-small.png') }}"
            alt="Img"></noscript>
      </a>
    </div>
    <!-- /Logo -->
    <a id="mobile_btn" class="mobile_btn" href="#sidebar">
      <span class="bar-icon">
        <span></span>
        <span></span>
        <span></span>
      </span>
    </a>

    <!-- Header Menu -->
    <ul class="nav user-menu">

      <!-- Search -->

      <!-- /Search -->
      {{-- @dd(Session::get('toko')) --}}
      <!-- Select Store -->
      @if (Session::has('toko'))
        <li class="nav-item dropdown has-arrow main-drop select-store-dropdown ms-auto">
          <a href="javascript:void(0);" class="dropdown-toggle nav-link select-store" data-bs-toggle="dropdown">
            <span class="user-info">
              <span class="user-letter">
                <img alt="Store Logo" class="img-fluid" data-cfsrc="{{ asset(Session::get('toko.logo')) }}"
                  style="display:none;visibility:hidden;"><noscript><img src="{{ asset(Session::get('toko.logo')) }}"
                    alt="Store Logo" class="img-fluid"></noscript>
              </span>
              <span class="user-detail">
                <span class="user-name">{{ Session::get('toko.name') }}</span>
              </span>
            </span>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            @if (Auth::user()->toko()->exists())
              @foreach (Auth::user()->toko as $item)
                <a href="{{ route('toko.sesi', $item->token_toko) }}" class="dropdown-item">
                  <img alt="Store Logo" class="img-fluid" data-cfsrc="{{ asset($item->logo) }}"
                    style="display:none;visibility:hidden;"><noscript><img src="{{ asset($item->logo) }}"
                      alt="Store Logo" class="img-fluid"></noscript>{{ $item->name }}
                </a>
              @endforeach
            @else
              @foreach (App\Models\Toko::get() as $item)
                <a href="{{ route('toko.sesi', $item->token_toko) }}" class="dropdown-item">
                  <img alt="Store Logo" class="img-fluid" data-cfsrc="{{ asset($item->logo) }}"
                    style="display:none;visibility:hidden;"><noscript><img src="{{ asset($item->logo) }}"
                      alt="Store Logo" class="img-fluid"></noscript>{{ $item->name }}
                </a>
              @endforeach
            @endif
          </div>
        </li>
      @endif
      <!-- /Select Store -->

      <li class="nav-item pos-nav">
        <a href="{{ url('post') }}" class="btn btn-dark btn-md d-inline-flex align-items-center">
          <i class="ti ti-device-laptop me-1"></i>KASIR
        </a>
      </li>

      <li class="nav-item nav-item-box">
        <a href="javascript:void(0);" id="btnFullscreen">
          <i class="ti ti-maximize"></i>
        </a>
      </li>

      <li class="nav-item dropdown has-arrow main-drop profile-nav">
        <a href="javascript:void(0);" class="nav-link userset" data-bs-toggle="dropdown">
          <span class="user-info p-0">
            <span class="user-letter">
              <img alt="Img" class="img-fluid" data-cfsrc="{{ asset(Auth::user()->avatar ?? 'gambar/profile/default.png') }}"
                style="display:none;visibility:hidden;"><noscript><img
                  src="{{ asset(Auth::user()->avatar ?? 'gambar/profile/default.png') }}" alt="Img" class="img-fluid"></noscript>
            </span>
          </span>
        </a>
        <div class="dropdown-menu menu-drop-user">
          <div class="profileset d-flex align-items-center">
            <span class="user-img me-2">
              <img alt="Img" data-cfsrc="{{ asset(Auth::user()->avatar ?? 'gambar/profile/default.png') }}"
                style="display:none;visibility:hidden;"><noscript><img
                  src="{{ asset(Auth::user()->avatar ?? 'gambar/profile/default.png') }}" alt="Img"></noscript>
            </span>
            <div>
              <h6 class="fw-medium">{{ Auth::user()->name }}</h6>
              <p>{{ Auth::user()->getRoleNames()->implode(', ') }}</p>
            </div>
          </div>
          <a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="ti ti-user-circle me-2"></i>MyProfile</a>

          <hr class="my-2">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dropdown-item logout pb-0">
              <i class="ti ti-logout me-2"></i>Logout
            </button>
          </form>
        </div>
      </li>
    </ul>
    <!-- /Header Menu -->

    <!-- Mobile Menu -->
    <div class="dropdown mobile-user-menu">
      <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
        aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>

      <div class="dropdown-menu dropdown-menu-end">
        <a class="dropdown-item" href="{{ route('profile.edit') }}">My Profile</a>
        <a class="dropdown-item" href="{{ url('post') }}">Kasir</a>

        @if (Session::has('toko'))
          <div class="dropdown-divider"></div>
          <h6 class="dropdown-header">Ganti Toko</h6>

          @if (Auth::user()->toko()->exists())
            @foreach (Auth::user()->toko as $item)
              <a href="{{ route('toko.sesi', $item->token_toko) }}"
                class="dropdown-item d-flex align-items-center gap-2">
                <img src="{{ asset($item->logo) }}" alt="Logo" width="20" height="20"
                  class="rounded" />
                {{ $item->name }}
              </a>
            @endforeach
          @else
            @foreach (App\Models\Toko::all() as $item)
              <a href="{{ route('toko.sesi', $item->token_toko) }}"
                class="dropdown-item d-flex align-items-center gap-2">
                <img src="{{ asset($item->logo) }}" alt="Logo" width="20" height="20"
                  class="rounded" />
                {{ $item->name }}
              </a>
            @endforeach
          @endif
        @endif

        <div class="dropdown-divider"></div>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="dropdown-item">Logout</button>
        </form>
      </div>
    </div>

    <!-- /Mobile Menu -->
  </div>
</div>
