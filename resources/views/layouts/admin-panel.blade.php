<!DOCTYPE html>
<html lang="en" data-layout-mode="light_mode">

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
  <title>Al-Kinza Resto & Cafe</title>

    <x-admin-panel.style></x-admin-panel.style>

</head>

<body>
  {{-- <div id="global-loader">
    <div class="whirly-loader"> </div>
  </div> --}}
  <!-- Main Wrapper -->
  <div class="main-wrapper">

    <x-admin-panel.alert></x-admin-panel.alert>

    <!-- Header -->
    <x-admin-panel.header></x-admin-panel.header>
    <!-- /Header -->

    <!-- Sidebar -->
    <x-admin-panel.sidebar></x-admin-panel.sidebar>
    <!-- /Sidebar -->

    <!-- Horizontal Sidebar -->
    <x-admin-panel.sidebar-horizontal></x-admin-panel.sidebar-horizontal>
    <!-- /Horizontal Sidebar -->

    <!-- Two Col Sidebar -->
    <x-admin-panel.sidebar-twocol></x-admin-panel.sidebar-twocol>
    <!-- /Two Col Sidebar -->

    <div class="page-wrapper">
      <div class="content">

        {{ $slot }}

      </div>
      <div
        class="copyright-footer d-flex align-items-center justify-content-between border-top bg-white gap-3 flex-wrap">
        <p class="fs-13 text-gray-9 mb-0">2014 - 2025 &copy; <a href="https://xplode.site/">XplodE</a> All Right Reserved</p>
        <p>Designed & Developed By <a href="javascript:void(0);" class="link-primary">RahmanSDK</a></p>
      </div>
    </div>

  </div>
  <!-- /Main Wrapper -->


  <x-admin-panel.scripts></x-admin-panel.scripts>

</body>

</html>
