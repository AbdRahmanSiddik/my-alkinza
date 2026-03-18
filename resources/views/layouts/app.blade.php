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
    <meta name="cf-rocket-loader" content="off">
    <title>Al-Kinza | Kasir</title>

    @livewireStyles

    <script src="{{ asset('pos/js/theme-script.js') }}" type="592636219711199e1fdb15e2-text/javascript"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset(Session::get('toko.logo')) }}">

    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset(Session::get('toko.logo')) }}">

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

        .cart-empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
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
                        style="display:none;visibility:hidden;"><noscript><img
                            src="{{ asset('assets/img/logo-small.png') }}" alt="Img"></noscript>
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
                    <li class="nav-item pos-nav ms-auto">
                        <a href="{{ route('dashboard') }}"
                            class="btn btn-purple btn-md d-inline-flex align-items-center">
                            <i class="ti ti-world me-1"></i>Dashboard
                        </a>
                    </li>

                    <!-- Select Store -->
                    @if (Session::has('toko'))
                        <li class="nav-item dropdown has-arrow main-drop select-store-dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle nav-link select-store"
                                data-bs-toggle="dropdown">
                                <span class="user-info">
                                    <span class="user-letter">
                                        <img alt="Store Logo" class="img-fluid"
                                            data-cfsrc="{{ asset(Session::get('toko.logo')) }}"
                                            style="display:none;visibility:hidden;"><noscript><img
                                                src="{{ asset(Session::get('toko.logo')) }}" alt="Store Logo"
                                                class="img-fluid"></noscript>
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
                                            <img alt="Store Logo" class="img-fluid"
                                                data-cfsrc="{{ asset($item->logo) }}"
                                                style="display:none;visibility:hidden;"><noscript><img
                                                    src="{{ asset($item->logo) }}" alt="Store Logo"
                                                    class="img-fluid"></noscript>{{ $item->name }}
                                        </a>
                                    @endforeach
                                @else
                                    @foreach (App\Models\Toko::get() as $item)
                                        <a href="{{ route('toko.sesi', $item->token_toko) }}" class="dropdown-item">
                                            <img alt="Store Logo" class="img-fluid"
                                                data-cfsrc="{{ asset($item->logo) }}"
                                                style="display:none;visibility:hidden;"><noscript><img
                                                    src="{{ asset($item->logo) }}" alt="Store Logo"
                                                    class="img-fluid"></noscript>{{ $item->name }}
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </li>
                    @endif
                    <!-- /Select Store -->
                @endif

                <li class="nav-item nav-item-box">
                    <a href="javascript:void(0);" id="btnFullscreen" data-bs-toggle="tooltip"
                        data-bs-placement="top" data-bs-title="Maximize">
                        <i class="ti ti-maximize"></i>
                    </a>
                </li>
                <li class="nav-item dropdown has-arrow main-drop profile-nav">
                    <a href="javascript:void(0);" class="nav-link userset" data-bs-toggle="dropdown">
                        <span class="user-info p-0">
                            <span class="user-letter">
                                <img alt="Img" class="img-fluid"
                                    data-cfsrc="{{ asset(Auth::user()->avatar ?? 'pos/img/profiles/avator1.jpg') }}"
                                    style="display:none;visibility:hidden;"><noscript><img
                                        src="{{ asset(Auth::user()->avatar ?? 'pos/img/profiles/avator1.jpg') }}"
                                        alt="Img" class="img-fluid"></noscript>
                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img"><img alt="Img"
                                        data-cfsrc="{{ asset(Auth::user()->avatar ?? 'pos/img/profiles/avator1.jpg') }}"
                                        style="display:none;visibility:hidden;"><noscript><img
                                            src="{{ asset(Auth::user()->avatar ?? 'pos/img/profiles/avator1.jpg') }}"
                                            alt="Img"></noscript>
                                    <span class="status online"></span></span>
                                <div class="profilesets">
                                    <h6>{{ Auth::user()->name }}</h6>
                                    <h5>{{ Auth::user()->getRoleNames()->first() ?? 'No Role' }}</h5>
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
                                    <img src="{{ asset('pos') }}/img/icons/log-out.svg" class="me-2"
                                        alt="img">Logout
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

                {{ $slot }}

                <div class="pos-footer bg-white p-3 border-top">
                    <div class="d-flex align-items-center justify-content-center flex-wrap gap-2">

                        <a href="{{ route('kasir') }}"
                            class="btn btn-purple d-inline-flex align-items-center justify-content-center">
                            <i class="ti ti-cash me-2"></i>Kasir</a>
                        <a href="javascript:void(0);"
                            class="btn btn-indigo d-inline-flex align-items-center justify-content-center"
                            data-bs-toggle="modal" data-bs-target="#reset"><i
                                class="ti ti-reload me-2"></i>Refresh</a>
                        <a href="{{ route('transaksi') }}"
                            class="btn btn-danger d-inline-flex align-items-center justify-content-center">
                            <i class="ti ti-shopping-cart me-2"></i>Transaksi</a>
                        @if (request()->routeIs('kasir'))
                            <a href="javascript:void(0);"
                                class="btn btn-warning d-inline-flex align-items-center justify-content-center"
                                data-bs-toggle="modal" data-bs-target="#pending-transactions">
                                <i class="ti ti-clock me-2"></i>Pending Transaksi</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /Main Wrapper -->

    {{-- toasts --}}
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100">
        <div id="livewire-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto" id="toast-title">Notification</strong>
                <small>Just now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toast-message">
                Message here
            </div>
        </div>
    </div>



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
                                            <img alt="Products"
                                                data-cfsrc="{{ asset('pos') }}/img/products/pos-product-16.png"
                                                style="display:none;visibility:hidden;"><noscript><img
                                                    src="{{ asset('pos') }}/img/products/pos-product-16.png"
                                                    alt="Products"></noscript>
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
                                            <img alt="Products"
                                                data-cfsrc="{{ asset('pos') }}/img/products/pos-product-17.png"
                                                style="display:none;visibility:hidden;"><noscript><img
                                                    src="{{ asset('pos') }}/img/products/pos-product-17.png"
                                                    alt="Products"></noscript>
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
                        <button type="button" class="btn btn-md btn-secondary"
                            data-bs-dismiss="modal">Cancel</button>
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
                                <button type="button" class="btn btn-md btn-secondary"
                                    data-bs-dismiss="modal">Tidak,
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

    <div class="modal fade modal-sweet" id="modal-error" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <span class="rounded-circle d-inline-flex p-2 bg-danger-transparent mb-2">
                        <i class="ti ti-x fs-24 text-danger"></i>
                    </span>
                    <h4 class="fs-20 fw-semibold">Gagal</h4>
                    <p class="error-message mb-0"></p>
                    <button type="button" class="btn btn-primary close-sweet-modal"
                        data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

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
    @stack('scripts')
    <script>
        let receiptModal;
        document.addEventListener('livewire:init', () => {
            Livewire.on('alert', ({
                type,
                message
            }) => {
                // 🔴 kalau error → munculin modal
                if (type === 'error') {

                    const modalEl = document.getElementById('modal-error');

                    // isi pesan error ke modal
                    const msgEl = modalEl.querySelector('.error-message');
                    if (msgEl) {
                        msgEl.innerText = message;
                    }

                    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modal.show();

                    return; // stop disini, jangan lanjut toast
                }

                // 🟢 selain error → pakai toast
                const toastEl = document.getElementById('livewire-toast');
                const toastHeader = toastEl.querySelector('.toast-header');
                const toastMsg = document.getElementById('toast-message');

                toastHeader.classList.remove(
                    'text-bg-success',
                    'text-bg-danger',
                    'text-bg-warning',
                    'text-bg-info',
                    'text-bg-secondary'
                );

                const bgMap = {
                    success: 'text-bg-success',
                    error: 'text-bg-danger',
                    warning: 'text-bg-warning',
                    info: 'text-bg-info',
                };

                toastHeader.classList.add(bgMap[type] ?? 'text-bg-secondary');
                toastMsg.innerText = message;

                const toast = bootstrap.Toast.getOrCreateInstance(toastEl, {
                    delay: 3000
                });

                toast.show();
            });


            receiptModal = new bootstrap.Modal(
                document.getElementById('print-receipt')
            );

            Livewire.on('openReceipt', ({
                transaksiId
            }) => {
                // load data transaksi ke modal
                fetch(`/pos/receipt/${transaksiId}`)
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('receipt-content').innerHTML = html;

                        receiptModal.show();
                    });
            });
            Livewire.on('closeModal', ({
                modalId
            }) => {
                const modalEl = document.getElementById(modalId);
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) {
                    modal.hide();
                }
            });
            Livewire.on('update-cash-input', e => {
                document.getElementById('cash').value = e.detail.value;
            });
            Livewire.on('showTransactionDetail', (event) => {

                const modalEl = document.getElementById('transaction-detail-modal');

                if (!modalEl) return;

                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();

            });
        });
    </script>
    <script>
        document.addEventListener('input', function(e) {

            if (e.target.id !== 'cash') return;

            let angka = e.target.value.replace(/[^\d]/g, '');

            if (!angka) {
                e.target.value = '';
                return;
            }

            e.target.value = new Intl.NumberFormat('id-ID').format(angka);
        });
    </script>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('openReceipt', (data) => {
                const transaksiId = data.transaksiId;
                const baseUrl = "v2.alkinza.site/api/android/receipt/";

                // Handle Tombol Print Biasa (Hanya Kasir & Cust)
                const btnAndroid = document.getElementById('btnPrintAndroid');
                if (btnAndroid) {
                    btnAndroid.href = `my.bluetoothprint.scheme://https://${baseUrl}${transaksiId}?type=basic`;
                    btnAndroid.classList.remove('d-none');
                }

                // Handle Tombol Print Lengkap (Kasir, Cust, Dapur, Bar)
                const btnFull = document.getElementById('btnPrintFull');
                if (btnFull) {
                    btnFull.href = `my.bluetoothprint.scheme://https://${baseUrl}${transaksiId}?type=full`;
                    btnFull.classList.remove('d-none');
                }

                const modal = new bootstrap.Modal(document.getElementById('print-receipt'));
                modal.show();
            });
        });
    </script>
    <script>
        document.addEventListener('livewire:init', () => {

            Livewire.on('openRekap', (data) => {

                window.location.href =
                    `my.bluetoothprint.scheme://https://v2.alkinza.site/api/android/rekap/${data.tanggal}/${data.tokoId}/${data.kasirId}`;

            });

        });
    </script>

    @livewireScripts
    {{-- @yield('script_pos') --}}
</body>

</html>
