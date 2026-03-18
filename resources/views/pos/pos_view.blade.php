<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Meta Tags -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description"
    content="Dreams POS is a powerful Bootstrap based Inventory Management Admin Template designed for businesses, offering seamless invoicing, project tracking, and estimates.">
  <meta name="keywords"
    content="inventory management, admin dashboard, bootstrap template, invoicing, estimates, business management, responsive admin, POS system">
  <meta name="author" content="Dreams Technologies">
  <meta name="robots" content="index, follow">
  <title>Al-Kinza | Kasir</title>

  <script src="{{ asset('pos/js/theme-script.js') }}" type="592636219711199e1fdb15e2-text/javascript"></script>

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('pos') }}/img/favicon.png">

  <!-- Apple Touch Icon -->
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('pos') }}/img/apple-touch-icon.png">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{ asset('pos') }}/css/bootstrap.min.css">

  <!-- Datetimepicker CSS -->
  <link rel="stylesheet" href="{{ asset('pos') }}/css/bootstrap-datetimepicker.min.css">

  <!-- animation CSS -->
  <link rel="stylesheet" href="{{ asset('pos') }}/css/animate.css">

  <!-- Select2 CSS -->
  <link rel="stylesheet" href="{{ asset('pos') }}/plugins/select2/css/select2.min.css">

  <!-- Datatable CSS -->
  <link rel="stylesheet" href="{{ asset('pos') }}/css/dataTables.bootstrap5.min.css">

  <!-- Fontawesome CSS -->
  <link rel="stylesheet" href="{{ asset('pos') }}/plugins/fontawesome/css/fontawesome.min.css">
  <link rel="stylesheet" href="{{ asset('pos') }}/plugins/fontawesome/css/all.min.css">

  <!-- Daterangepikcer CSS -->
  <link rel="stylesheet" href="{{ asset('pos') }}/plugins/daterangepicker/daterangepicker.css">

  <!-- Tabler Icon CSS -->
  <link rel="stylesheet" href="{{ asset('pos') }}/plugins/tabler-icons/tabler-icons.css">

  <!-- Owl Carousel CSS -->
  <link rel="stylesheet" href="{{ asset('pos') }}/plugins/owlcarousel/owl.carousel.min.css">
  <link rel="stylesheet" href="{{ asset('pos') }}/plugins/owlcarousel/owl.theme.default.min.css">

  <!-- Color Picker Css -->
  <link rel="stylesheet" href="{{ asset('pos') }}/plugins/%40simonwep/pickr/themes/nano.min.css">

  <!-- Main CSS -->
  <link rel="stylesheet" href="{{ asset('pos') }}/css/style.css">

  <style>
    .fade-transition {
      transition: opacity 0.3s ease;
    }
  </style>

</head>

<body class="pos-page">
  <div id="global-loader">
    <div class="whirly-loader"> </div>
  </div>
  <!-- Main Wrapper -->
  <div class="main-wrapper pos-five">

    <!-- Header -->
    <div class="header pos-header">

      <!-- Logo -->
      <div class="header-left active">
        <a href="{{ url('post') }}" class="logo logo-normal">
          <img src="{{ asset(Session::get('toko.logo')) }}" alt="Img" height="50px">
        </a>
        <a href="{{ url('post') }}" class="logo logo-white">
          <img src="{{ asset('assets/img/logo-white.svg') }}" alt="Img">
        </a>
        <a href="{{ url('post') }}" class="logo-small">
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

      <a id="mobile_btn" class="mobile_btn d-none" href="#sidebar">
        <span class="bar-icon">
          <span></span>
          <span></span>
          <span></span>
        </span>
      </a>

      <!-- Header Menu -->
      <ul class="nav user-menu">

        <!-- Search -->
        <li class="nav-item time-nav">
          <span class="bg-teal text-white d-inline-flex align-items-center">
            <img src="{{ asset('pos') }}/img/icons/clock-icon.svg" alt="img" class="me-2">
            <span id="realtime-clock"></span>
          </span>
          <script>
            function updateClock() {
              const now = new Date();
              const h = String(now.getHours()).padStart(2, '0');
              const m = String(now.getMinutes()).padStart(2, '0');
              const s = String(now.getSeconds()).padStart(2, '0');
              document.getElementById('realtime-clock').textContent = `${h}:${m}:${s}`;
            }
            setInterval(updateClock, 1000);
            updateClock();
          </script>
        </li>
        <!-- /Search -->

        @if (!Auth::user()->hasRole(['kasir', 'user']))
          <li class="nav-item pos-nav">
            <a href="{{ route('dashboard') }}" class="btn btn-purple btn-md d-inline-flex align-items-center">
              <i class="ti ti-world me-1"></i>Dashboard
            </a>
          </li>

          <!-- Select Store -->
          @if (Session::has('toko'))
            <li class="nav-item dropdown has-arrow main-drop select-store-dropdown ms-auto">
              <a href="javascript:void(0);" class="dropdown-toggle nav-link select-store" data-bs-toggle="dropdown">
                <span class="user-info">
                  <span class="user-letter">
                    <img alt="Store Logo" class="img-fluid" data-cfsrc="{{ asset(Session::get('toko.logo')) }}"
                      style="display:none;visibility:hidden;"><noscript><img
                        src="{{ asset(Session::get('toko.logo')) }}" alt="Store Logo" class="img-fluid"></noscript>
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
        @endif

        <li class="nav-item nav-item-box">
          <a href="javascript:void(0);" id="btnFullscreen" data-bs-toggle="tooltip" data-bs-placement="top"
            data-bs-title="Maximize">
            <i class="ti ti-maximize"></i>
          </a>
        </li>
        <li class="nav-item dropdown has-arrow main-drop profile-nav">
          <a href="javascript:void(0);" class="nav-link userset" data-bs-toggle="dropdown">
            <span class="user-info p-0">
              <span class="user-letter">
                <img alt="Img" class="img-fluid" data-cfsrc="{{ asset('pos') }}/img/profiles/avator1.jpg"
                  style="display:none;visibility:hidden;"><noscript><img
                    src="{{ asset('pos') }}/img/profiles/avator1.jpg" alt="Img" class="img-fluid"></noscript>
              </span>
            </span>
          </a>
          <div class="dropdown-menu menu-drop-user">
            <div class="profilename">
              <div class="profileset">
                <span class="user-img"><img alt="Img" data-cfsrc="{{ asset('pos') }}/img/profiles/avator1.jpg"
                    style="display:none;visibility:hidden;"><noscript><img
                      src="{{ asset('pos') }}/img/profiles/avator1.jpg" alt="Img"></noscript>
                  <span class="status online"></span></span>
                <div class="profilesets">
                  <h6>{{ Session::get('user.name') }}</h6>
                  <h5>{{ Session::get('user.role') }}</h5>
                </div>
              </div>
              <hr class="m-0">
              <a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="me-2"
                  data-feather="user"></i>My
                Profile</a>
              <hr class="m-0">
              <form action="{{ url('logout') }}" method="POST" class="dropdown-item logout pb-0">
                @csrf
                <button type="submit" style="background: none; border: none; padding: 0;">
                  <img src="{{ asset('pos') }}/img/icons/log-out.svg" class="me-2" alt="img">Logout
                </button>
              </form>
            </div>
          </div>
        </li>
      </ul>
      <!-- /Header Menu -->

      <!-- Mobile Menu -->
      <div class="dropdown mobile-user-menu">
        <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
          aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="{{ route('profile.edit') }}">My Profile</a>
          <form action="{{ url('logout') }}" method="POST" class="dropdown-item logout pb-0">
            @csrf
            <button type="submit" style="background: none; border: none; padding: 0;">
              Logout
            </button>
          </form>
        </div>
      </div>
      <!-- /Mobile Menu -->
    </div>
    <!-- Header -->


    <div class="page-wrapper pos-pg-wrapper ms-0">
      <div class="content pos-design p-0">

        <div class="row pos-wrapper">

          <!-- Products -->
          @include('pos.in_produk')
          <!-- /Products -->

          <!-- Order Details -->
          @include('pos.in_keranjang')
          <!-- /Order Details -->

        </div>

        <div class="pos-footer bg-white p-3 border-top">
          <div class="d-flex align-items-center justify-content-center flex-wrap gap-2">

            <a href="javascript:void(0);"
              class="btn btn-indigo d-inline-flex align-items-center justify-content-center" data-bs-toggle="modal"
              data-bs-target="#reset"><i class="ti ti-reload me-2"></i>Refresh</a>
            <a href="javascript:void(0);"
              class="btn btn-danger d-inline-flex align-items-center justify-content-center" data-bs-toggle="modal"
              data-bs-target="#recents"><i class="ti ti-shopping-cart me-2"></i>Transaction</a>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- /Main Wrapper -->



  <!-- Products -->
  <div class="modal fade modal-default pos-modal" id="products" aria-labelledby="products">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center">
            <h5 class="me-4">Products</h5>
          </div>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card bg-light mb-3">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap mb-3">
                <span class="badge bg-dark fs-12">Order ID : #45698</span>
                <p class="fs-16">Number of Products : 02</p>
              </div>
              <div class="product-wrap h-auto">
                <div class="product-list bg-white align-items-center justify-content-between">
                  <div class="d-flex align-items-center product-info" data-bs-toggle="modal"
                    data-bs-target="#products">
                    <a href="javascript:void(0);" class="pro-img">
                      <img alt="Products" data-cfsrc="{{ asset('pos') }}/img/products/pos-product-16.png"
                        style="display:none;visibility:hidden;"><noscript><img
                          src="{{ asset('pos') }}/img/products/pos-product-16.png" alt="Products"></noscript>
                    </a>
                    <div class="info">
                      <h6><a href="javascript:void(0);">Red Nike Laser</a></h6>
                      <p>Quantity : 04</p>
                    </div>
                  </div>
                  <p class="text-teal fw-bold">$2000</p>
                </div>
                <div class="product-list bg-white align-items-center justify-content-between">
                  <div class="d-flex align-items-center product-info" data-bs-toggle="modal"
                    data-bs-target="#products">
                    <a href="javascript:void(0);" class="pro-img">
                      <img alt="Products" data-cfsrc="{{ asset('pos') }}/img/products/pos-product-17.png"
                        style="display:none;visibility:hidden;"><noscript><img
                          src="{{ asset('pos') }}/img/products/pos-product-17.png" alt="Products"></noscript>
                    </a>
                    <div class="info">
                      <h6><a href="javascript:void(0);">Iphone 11S</a></h6>
                      <p>Quantity : 04</p>
                    </div>
                  </div>
                  <p class="text-teal fw-bold">$3000</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /Products -->

  <div class="modal fade" id="create" tabindex="-1" aria-labelledby="create" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="https://dreamspos.dreamstechnologies.com/html/template/pos.html">
          <div class="modal-body pb-1">
            <div class="row">
              <div class="col-lg-6 col-sm-12 col-12">
                <div class="mb-3">
                  <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control">
                </div>
              </div>
              <div class="col-lg-6 col-sm-12 col-12">
                <div class="mb-3">
                  <label class="form-label">Phone <span class="text-danger">*</span></label>
                  <input type="text" class="form-control">
                </div>
              </div>
              <div class="col-lg-12">
                <div class="mb-3">
                  <label class="form-label">Email</label>
                  <input type="email" class="form-control">
                </div>
              </div>
              <div class="col-lg-12">
                <div class="mb-3">
                  <label class="form-label">Address</label>
                  <input type="text" class="form-control">
                </div>
              </div>
              <div class="col-lg-6 col-sm-12 col-12">
                <div class="mb-3">
                  <label class="form-label">City</label>
                  <input type="text" class="form-control">
                </div>
              </div>
              <div class="col-lg-6 col-sm-12 col-12">
                <div class="mb-3">
                  <label class="form-label">Country</label>
                  <input type="text" class="form-control">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer d-flex justify-content-end gap-2 flex-wrap">
            <button type="button" class="btn btn-md btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-md btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Delete Product -->
  <div class="modal fade modal-default" id="delete" aria-labelledby="payment-completed">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body p-0">
          <div class="success-wrap text-center">
            <form action="https://dreamspos.dreamstechnologies.com/html/template/pos.html">
              <div class="icon-success bg-danger-transparent text-danger mb-2">
                <i class="ti ti-trash"></i>
              </div>
              <h3 class="mb-2">Are you Sure!</h3>
              <p class="fs-16 mb-3">The current order will be deleted as no payment has been made so
                far.
              </p>
              <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
                <button type="button" class="btn btn-md btn-secondary" data-bs-dismiss="modal">No,
                  Cancel</button>
                <button type="submit" class="btn btn-md btn-primary">Yes, Delete</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /Delete Product -->

  <!-- Reset -->
  <div class="modal fade modal-default" id="reset" aria-labelledby="payment-completed">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body p-0">
          <div class="success-wrap text-center">
            <form action="/post" method="GET">
              <div class="icon-success bg-purple-transparent text-purple mb-2">
                <i class="ti ti-transition-top"></i>
              </div>
              <h3 class="mb-2">Apakah Anda Yakin?</h3>
              <p class="fs-16 mb-3">Pesanan saat ini akan dibersihkan. Tetapi tidak dihapus jika
                bersifat persisten. Apakah Anda ingin melanjutkan?</p>
              <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
                <button type="button" class="btn btn-md btn-secondary" data-bs-dismiss="modal">Tidak,
                  Batal</button>
                <button type="submit" class="btn btn-md btn-primary">Ya, Lanjutkan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /Reset -->

  <!-- Recent Transactions -->
  @include('pos.in_recent')
  <!-- /Recent Transactions -->

  <!-- Orders -->
  @include('pos.in_order')
  <!-- /Orders -->


  <!-- Discount -->
  <div class="modal fade modal-default" id="discount">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Discount </h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="https://dreamspos.dreamstechnologies.com/html/template/pos.html">
          <div class="modal-body pb-1">
            <div class="mb-3">
              <label class="form-label">Order Discount Type <span class="text-danger">*</span></label>
              <select class="select">
                <option>Select</option>
                <option>Flat</option>
                <option>Percentage</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Value <span class="text-danger">*</span></label>
              <input type="text" class="form-control">
            </div>
          </div>
          <div class="modal-footer d-flex justify-content-end flex-wrap gap-2">
            <button type="button" class="btn btn-md btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-md btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- /Discount -->


  <!-- Today's Profit -->
  <div class="modal fade pos-modal" id="today-profit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Today's Profit</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">x</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-center g-3 mb-3">
            <div class="col-lg-4 col-md-6 d-flex">
              <div class="border border-success bg-success-transparent br-8 p-3 flex-fill">
                <p class="fs-16 text-gray-9 mb-1">Total Sale</p>
                <h3 class="text-success">$89954</h3>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 d-flex">
              <div class="border border-danger bg-danger-transparent br-8 p-3 flex-fill">
                <p class="fs-16 text-gray-9 mb-1">Expense</p>
                <h3 class="text-danger">$89954</h3>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 d-flex">
              <div class="border border-info bg-info-transparent br-8 p-3 flex-fill">
                <p class="fs-16 text-gray-9 mb-1">Total Profit </p>
                <h3 class="text-info">$2145</h3>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-striped border">
              <tr>
                <td>Product Revenue</td>
                <td class="text-gray-9 fw-medium text-end">$565597.88</td>
              </tr>
              <tr>
                <td>Product Cost</td>
                <td class="text-gray-9 fw-medium text-end">$3355.84</td>
              </tr>
              <tr>
                <td>Expense</td>
                <td class="text-gray-9 fw-medium text-end">$1959</td>
              </tr>
              <tr>
                <td>Total Stock Adjustment</td>
                <td class="text-gray-9 fw-medium text-end">$0</td>
              </tr>
              <tr>
                <td>Deposit Payment</td>
                <td class="text-gray-9 fw-medium text-end">$565597.88</td>
              </tr>
              <tr>
                <td>Total Purchase Shipping Cost</td>
                <td class="text-gray-9 fw-medium text-end">$3355.84</td>
              </tr>
              <tr>
                <td>Total Sell Discount</td>
                <td class="text-gray-9 fw-medium text-end">$565597.88</td>
              </tr>
              <tr>
                <td>Total Sell Return</td>
                <td class="text-gray-9 fw-medium text-end">$3355.84</td>
              </tr>
              <tr>
                <td>Closing Stock</td>
                <td class="text-gray-9 fw-medium text-end">$3355.84</td>
              </tr>
              <tr>
                <td>Total Sales</td>
                <td class="text-gray-9 fw-medium text-end">$565597.88</td>
              </tr>
              <tr>
                <td>Total Sale Return</td>
                <td class="text-gray-9 fw-medium text-end">$565597.88</td>
              </tr>
              <tr>
                <td>Total Expense</td>
                <td class="text-gray-9 fw-medium text-end">$565597.88</td>
              </tr>
              <tr>
                <td class="text-gray-9 fw-bold bg-secondary-transparent">Total Cash</td>
                <td class="text-gray-9 fw-bold text-end bg-secondary-transparent">$587130.97</td>
              </tr>
            </table>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-end gap-2 flex-wrap">
          <button type="button" class="btn btn-md btn-primary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  <!-- /Today's Profit -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!-- Feather Icon JS -->
  <script src="{{ asset('pos') }}/js/feather.min.js" type="5ed4e1fa019b2c1314c8869f-text/javascript"></script>

  <!-- Slimscroll JS -->
  <script src="{{ asset('pos') }}/js/jquery.slimscroll.min.js" type="5ed4e1fa019b2c1314c8869f-text/javascript"></script>

  <!-- Bootstrap Core JS -->
  <script src="{{ asset('pos') }}/js/bootstrap.bundle.min.js" type="5ed4e1fa019b2c1314c8869f-text/javascript"></script>

  <!-- Chart JS -->
  <script src="{{ asset('pos') }}/plugins/apexchart/apexcharts.min.js" type="5ed4e1fa019b2c1314c8869f-text/javascript"></script>
  <script src="{{ asset('pos') }}/plugins/apexchart/chart-data.js" type="5ed4e1fa019b2c1314c8869f-text/javascript"></script>

  <!-- Datatable JS -->
  <script src="{{ asset('pos') }}/js/jquery.dataTables.min.js" type="5ed4e1fa019b2c1314c8869f-text/javascript"></script>
  <script src="{{ asset('pos') }}/js/dataTables.bootstrap5.min.js" type="5ed4e1fa019b2c1314c8869f-text/javascript"></script>

  <!-- Daterangepikcer JS -->
  <script src="{{ asset('pos') }}/js/moment.min.js" type="5ed4e1fa019b2c1314c8869f-text/javascript"></script>
  <script src="{{ asset('pos') }}/plugins/daterangepicker/daterangepicker.js" type="5ed4e1fa019b2c1314c8869f-text/javascript"></script>

  <!-- Owl JS -->
  <script src="{{ asset('pos/plugins/owlcarousel/owl.carousel.min.js') }}" type="5ed4e1fa019b2c1314c8869f-text/javascript"></script>

  <!-- Select2 JS -->
  <script src="{{ asset('pos') }}/plugins/select2/js/select2.min.js" type="5ed4e1fa019b2c1314c8869f-text/javascript"></script>

  <!-- Sticky-sidebar -->
  <script src="{{ asset('pos') }}/plugins/theia-sticky-sidebar/ResizeSensor.js" type="5ed4e1fa019b2c1314c8869f-text/javascript"></script>
  <script src="{{ asset('pos') }}/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js" type="5ed4e1fa019b2c1314c8869f-text/javascript"></script>

  <!-- Color Picker JS -->
  <script src="{{ asset('pos') }}/plugins/%40simonwep/pickr/pickr.es5.min.js" type="5ed4e1fa019b2c1314c8869f-text/javascript"></script>

  <!-- Custom JS -->
  <script src="{{ asset('pos') }}/js/theme-colorpicker.js" type="5ed4e1fa019b2c1314c8869f-text/javascript"></script>
  <script src="{{ asset('pos') }}/js/script.js" type="5ed4e1fa019b2c1314c8869f-text/javascript"></script>

  <script src="{{ asset('pos') }}/rocket/rocket-loader.min.js" data-cf-settings="5ed4e1fa019b2c1314c8869f-|49" defer>
  </script>
  <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
    integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
    data-cf-beacon='{"rayId":"92c84726ff5444bf","version":"2025.3.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}'
    crossorigin="anonymous"></script>

  @yield('script_pos')

  <script></script>
<script>
    // Function to initialize/reinitialize Owl Carousel
    function initOwlCarousel() {
        $('.owl-carousel').each(function() {
            if (!$(this).hasClass('owl-loaded')) {
                $(this).owlCarousel({
                    loop: true,
                    margin: 10,
                    nav: true,
                    responsive: {
                        0: { items: 1 },
                        600: { items: 3 },
                        1000: { items: 5 }
                    }
                });
            }
        });
    }

    // Initialize on first page load
    $(document).ready(function() {
        initOwlCarousel();
    });

    // Reinitialize after AJAX requests complete
    $(document).ajaxComplete(function() {
        initOwlCarousel();
    });

    // Observer for DOM changes (alternative to ajaxComplete for dynamic content)
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length) {
                initOwlCarousel();
            }
        });
    });

    // Start observing the document body for changes
    $(document).ready(function() {
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    });
</script>
</body>

</html>
