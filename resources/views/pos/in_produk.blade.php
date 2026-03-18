<div class="col-md-12 col-lg-7 col-xl-8 d-flex">
    <div class="pos-categories tabs_wrapper p-0 flex-fill">
        <div class="content-wrap">
            <div class="tab-wrap">
                <ul class="tabs owl-carousel pos-category5" id="tmp-data-kategori">
                </ul>
            </div>
            <div class="tab-content-wrap">
                <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
                    <div class="mb-3">
                        <h5 class="mb-1">Halo, {{ Auth::user()->name }}</h5>
                        {{-- <button data-bs-toggle="modal" data-bs-target="#modalMeja"></button> --}}
                        <p>{{ Carbon\Carbon::now()->format('l, d F Y') }}</p>
                    </div>
                    <div class="d-flex align-items-center flex-wrap mb-2">
                        <button type="button" class="btn btn-primary me-3 mb-2" id="btn-pending-orders">
                            <i class="ti ti-clock me-2"></i>Transaksi Pending
                        </button>
                        <div class="input-icon-start search-pos position-relative mb-2 me-3">
                            <span class="input-icon-addon">
                                <i class="ti ti-search"></i>
                            </span>
                            <input type="text" id="search-product" class="form-control" placeholder="Search Product">
                        </div>
                    </div>
                </div>
                <div class="pos-products">
                    <div class="row g-3" id="tmp-data-produk">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Pending Transactions -->
<div class="modal fade" id="modalPending" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalPendingLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalPendingLabel">Transaksi Pending</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="tmp-modal-pending"></div>
            </div>

        </div>
    </div>
</div>


<div id="toastContainer" class="toast-container position-fixed bottom-0 start-0 p-3" style="z-index: 9999;"></div>

<iframe id="print-frame" style="display:none;"></iframe>


@section('script_pos')
    @include('components.scripts.kasir-script')
    {{-- <script>
    $(document).on('click', '#btnPrintReceipt', function() {
      const printContents = document.querySelector('#tmp-print').innerHTML;

      const printWindow = window.open('', '', 'width=400,height=600');
      printWindow.document.write(`
      <html>
        <head>
          <title>Print Receipt</title>
          <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
          <style>
            @media print {
              body {
                font-size: 12px;
                margin: 0 auto;
                padding: 10px;
                width: 80mm; /* thermal paper width */
              }
              .text-end { text-align: right; }
              .text-center { text-align: center; }
              .fw-bold { font-weight: bold; }
              table { width: 100%; border-collapse: collapse; }
              th, td { padding: 4px; }
              .border-bottom {
                border-bottom: 1px dashed #ccc;
                margin: 10px 0;
              }
              a, .btn, .invoice-bar a { display: none !important; }
            }
          </style>
        </head>
        <body onload="window.print(); window.close();">
          <div class="text-center">
            <img src="{{ asset('assets/img/logo.svg') }}" width="100" alt="Logo" style="filter: grayscale(1);"><br>
            <h6>{{ Session::get('toko.name') }}</h6>
          </div>
          ${printContents}
          <div class="text-center border-bottom">
            <p><em>**Terima kasih telah berbelanja.<br>Selamat menikmati!</em></p>
          </div>
        </body>
      </html>
    `);
      printWindow.document.close();
    });
  </script> --}}

    <script>
        $(document).on('click', '#btnPrintReceipt', function() {
            const printContents = document.querySelector('#tmp-print').innerHTML;
            const iframe = document.getElementById('print-frame');
            const doc = iframe.contentWindow.document;

            doc.open();
            doc.write(`
      <html>
        <head>
          <title>Print Receipt</title>
          <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
          <style>
            body {
              font-size: 12px;
              margin: 0;
              padding: 10px;
              width: 80mm;
            }
            table { width: 100%; }
            th, td { padding: 4px; }
            .text-end { text-align: right; }
            .text-center { text-align: center; }
            .fw-bold { font-weight: bold; }
            .border-bottom {
              border-bottom: 1px dashed #ccc;
              margin: 10px 0;
            }
          </style>
        </head>
        <body>
          <div class="text-center">
            <img src="{{ asset('assets/img/logo.svg') }}" width="100" style="filter: grayscale(1);"><br>
            <h6>{{ Session::get('toko.name') }}</h6>
          </div>

          ${printContents}

          <div class="text-center border-bottom">
            <p><em>**Terima kasih telah berbelanja<br>Selamat menikmati!</em></p>
          </div>
        </body>
      </html>
    `);
            doc.close();

            setTimeout(() => {
                iframe.contentWindow.focus();
                iframe.contentWindow.print();
            }, 500);
        });
    </script>
@endsection
