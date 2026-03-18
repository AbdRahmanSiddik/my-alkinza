<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />
  <title>Al-Kinza Resto & Cafe</title>
  <link rel="icon" type="image/png" href="{{ asset('regfood/assets/images/favicon.png') }}">
  <link rel="stylesheet" href="{{ asset('regfood/assets/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('regfood/assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('regfood/assets/css/slick.css') }}">
  <link rel="stylesheet" href="{{ asset('regfood/assets/css/nice-select.css') }}">
  <link rel="stylesheet" href="{{ asset('regfood/assets/css/custom_spacing.css') }}">
  <link rel="stylesheet" href="{{ asset('regfood/assets/css/venobox.min.css') }}">
  <link rel="stylesheet" href="{{ asset('regfood/assets/css/animate.css') }}">
  <link rel="stylesheet" href="{{ asset('regfood/assets/css/jquery.exzoom.css') }}">
  <link rel="stylesheet" href="{{ asset('regfood/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('regfood/assets/css/responsive.css') }}">
  <style>
  .dropdown-menu .dropdown-item {
    background: none !important;
    color: #212529 !important;
    font-weight: 400 !important;
    padding: 0.5rem 1rem;
    border-radius: 0 !important;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .dropdown-menu .dropdown-item:hover {
    background-color: #f8f9fa;
    color: #c35515;
  }

  .dropdown-menu .dropdown-item i {
    font-size: 14px;
    width: 18px;
    text-align: center;
  }
</style>

</head>

<body>

  <!--=============================
        TOPBAR START
    ==============================-->
  <section class="topbar">
    <div class="container">
      <div class="row">
        <div class="col-xl-6 col-sm-6 col-md-8">
          <ul class="topbar_info d-flex flex-wrap d-none d-sm-flex">
            <li><a href="mailto:alkinza.restocafe@gmail.com"><i class="fas fa-envelope"></i>
                alkinza.restocafe@gmail.com</a>
            </li>
            <li class="d-none d-md-block"><a href="callto:123456789"><i class="fas fa-phone-alt"></i>
                +96487452145214</a></li>
          </ul>
        </div>
        <div class="col-xl-6 col-sm-6 col-md-4">
          <ul class="topbar_icon d-flex flex-wrap">
            <li><a href="#"><i class="fab fa-facebook-f"></i></a> </li>
            <li><a href="#"><i class="fab fa-twitter"></i></a> </li>
            <li><a href="#"><i class="fab fa-linkedin-in"></i></a> </li>
            <li><a href="#"><i class="fab fa-behance"></i></a> </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <!--=============================
        TOPBAR END
    ==============================-->


  <!--=============================
        MENU START
    ==============================-->
  <nav class="navbar navbar-expand-lg main_menu">
    <div class="container">
      <a class="navbar-brand" href="/" style="width: 80px;">
        <img src="{{ asset('assets/img/logo.svg') }}" alt="Al-Kinza" class="img-fluid">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <i class="far fa-bars menu_icon_bar"></i>
        <i class="far fa-times close_icon_close"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav m-auto">
          {{-- <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('shop.index') ? 'active' : '' }}" aria-current="page"
              href="{{ route('shop.index') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('shop.menu') ? 'active' : '' }}" href="#">menu <i
                class="far fa-angle-down"></i></a>
            <ul class="droap_menu">
              @foreach ($shops as $token => $nama)
                <li>
                  <a class="{{ request()->routeIs('shop.menu') && request()->route('token_toko') == $token ? 'active' : '' }}"
                    href="{{ route('shop.menu', ['token_toko' => $token]) }}">
                    Toko {{ $nama }}
                  </a>
                </li>
              @endforeach
            </ul>
          </li>
          @auth
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('shop.pesanan') ? 'active' : '' }}" href="#">Pesanan Saya <i
                  class="far fa-angle-down"></i></a>
              <ul class="droap_menu">
                @foreach ($shops as $token => $nama)
                  <li>
                    <a class="{{ request()->routeIs('shop.pesanan') && request()->route('token_toko') == $token ? 'active' : '' }}"
                      href="{{ route('shop.pesanan', ['token_toko' => $token]) }}">
                      Toko {{ $nama }}
                    </a>
                  </li>
                @endforeach
              </ul>
            </li>
          @endauth --}}
        </ul>
        <ul class="menu_icon d-flex flex-wrap">
          @if (request()->routeIs('shop.menu'))
            @auth
              <li>
                <a class="cart_icon" role="button" data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas"
                  aria-controls="cartOffcanvas">
                  <i class="fas fa-shopping-basket"></i>
                  <span id="items"></span>
                </a>
              </li>
            @endauth
          @endif
          @guest
            <li>
              <a href="{{ route('login') }}"><i class="fas fa-user"></i></a>
            </li>
          @endguest
          @auth
            <li class="nav-item dropdown d-flex align-items-center gap-2">
              <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                @if (Auth::user()->avatar)
                  <img src="{{ Auth::user()->avatar }}" alt="Avatar" class="rounded-circle" width="28"
                    height="28" style="object-fit: cover;">
                @else
                  <i class="fas fa-user"></i>
                @endif
            </a>
            <span class="ms-1">{{ Auth::user()->name }}</span>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                @if (Auth::user()->hasAnyRole(['admin', 'core', 'operator']))
                    <li>
                      <a class="dropdown-item" href="{{ route('dashboard') }}">
                        Dashboard
                      </a>
                    </li>
                @endif
                <li>
                  <a class="dropdown-item" href="{{ route('profile.edit') }}">
                    Profile
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                  </form>
                </li>
              </ul>
            </li>
          @endauth



        </ul>
      </div>
    </div>
  </nav>
  <!--=============================
        MENU END
    ==============================-->

  {{ $slot }}

  {{-- @include('shop._card-list') --}}

  <!--=============================
        FOOTER START
    ==============================-->
  <footer style="background: url(images/footer_bg.jpg);">
    <div class="footer_bottom d-flex flex-wrap">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="footer_bottom_text">
              <p>Copyright ©<b> <a href="https://xplode.site" target="_blank">RahmanSDK</a> </b> {{ date('Y') }}. All Rights Reserved</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!--=============================
        FOOTER END
    ==============================-->


  <!--=============================
        SCROLL BUTTON START
    ==============================-->
  <div class="scroll_btn"><i class="fas fa-hand-pointer"></i></div>
  <!--=============================
        SCROLL BUTTON END
    ==============================-->


  <!--jquery library js-->
  <script src="{{ asset('regfood/assets/js/jquery-3.6.0.min.js') }}"></script>
  <!--bootstrap js-->
  <script src="{{ asset('regfood/assets/js/bootstrap.bundle.min.js') }}"></script>
  <!--font-awesome js-->
  <script src="{{ asset('regfood/assets/js/Font-Awesome.js') }}"></script>
  <!-- slick slider -->
  <script src="{{ asset('regfood/assets/js/slick.min.js') }}"></script>
  <!-- isotop js -->
  <script src="{{ asset('regfood/assets/js/isotope.pkgd.min.js') }}"></script>
  <!-- counter up js -->
  <script src="{{ asset('regfood/assets/js/jquery.waypoints.min.js') }}"></script>
  <script src="{{ asset('regfood/assets/js/jquery.countup.min.js') }}"></script>
  <!-- nice select js -->
  <script src="{{ asset('regfood/assets/js/jquery.nice-select.min.js') }}"></script>
  <!-- venobox js -->
  <script src="{{ asset('regfood/assets/js/venobox.min.js') }}"></script>
  <!-- sticky sidebar js -->
  <script src="{{ asset('regfood/assets/js/sticky_sidebar.js') }}"></script>
  <!-- wow js -->
  <script src="{{ asset('regfood/assets/js/wow.min.js') }}"></script>
  <!-- ex zoom js -->
  <script src="{{ asset('regfood/assets/js/jquery.exzoom.js') }}"></script>

  <!--main/custom js-->
  <script src="{{ asset('regfood/assets/js/main.js') }}"></script>


</body>

</html>
