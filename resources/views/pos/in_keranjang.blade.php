<div class="col-md-12 col-lg-5 col-xl-4 ps-0 theiaStickySidebar ">
  <aside class="product-order-list bg-secondary-transparent flex-fill">
    <div class="card">
      <div class="card-body">
        <div class="customer-info block-section">
          <h5 class="mb-2">Customer Information</h5>
          <div class="d-flex align-items-center gap-2">
            <div class="col-12">
              <input type="text" id="namaCust" class="form-control mb-3" placeholder="Atas nama (optional)">
            </div>
          </div>
        </div>
        <div class="product-added block-section">
          <div class="head-text d-flex align-items-center justify-content-between mb-3">
            <div class="d-flex align-items-center">
              <h5 class="me-2">Order Details</h5>
              <div class="badge bg-light text-gray-9 fs-12 fw-semibold py-2 border rounded">
                Items : <span class="text-teal" id="counter-item"></span></div>
            </div>
            <a href="javascript:void(0);" class="d-flex align-items-center clear-icon fs-10 fw-medium">Clear
              all</a>
          </div>
          <div class="mb-2">
            <small class="text-muted">Kode Transaksi: <strong id="kode-transaksi">-</strong></small>
          </div>
          <div class="product-wrap">

            <div class="product-list border-0 p-0">
              <div class="table-responsive">
                <table class="table table-borderless table-hover">
                  <thead>
                    <tr>
                      <th class="fw-bold bg-light" width="40%">Item</th>
                      <th class="fw-bold bg-light">Kuantitas</th>
                      <th class="fw-bold bg-light text-end">Harga</th>
                    </tr>
                  </thead>
                  <tbody id="tmp-data-keranjang">

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="order-total bg-total bg-white p-0">
          <table class="table table-responsive table-borderless">
            <tr>
              <td>Sub Total</td>
              <td class="text-gray-9 text-end" id="subtotals">Rp</td>
            </tr>
            {{-- <tr>
              <td>
                <span class="text-danger">Discount</span>
                <a href="#" class="ms-3 link-default" data-bs-toggle="modal" data-bs-target="#discount">
                  <i class="ti ti-edit"></i>
                </a>
              </td>
              <td class="text-danger text-end">0</td>
            </tr> --}}
            <tr>
              <td class="fw-bold border-top border-dashed">Total Tagihan</td>
              <td class="text-gray-9 fw-bold text-end border-top border-dashed" id="total"></td>
            </tr>
          </table>
        </div>
      </div>
    </div>

    <form action="POST" action="" id="form-transaksi" style="padding-bottom: 13vh;">
      <div class="card payment-method">
        <div class="card-body px-0" id="bayar-section">
          <h5 class="mb-3" style="margin-left: 20px">Select Payment</h5>
          <table class="table table-borderless table-responsive">
            <tr>
              <td colspan="2" class="pb-2">
                <div class="form-check" style="margin-left: 20px">
                  <input class="form-check-input" type="checkbox" id="checkbox-bayar-pas">
                  <label class="form-check-label" for="checkbox-bayar-pas">
                    Bayar Pas / Non Tunai
                  </label>
                </div>
              </td>
            </tr>
            <tr>
              <td class="align-top w-50">Bayar</td>
              <td class="pt-0 text-end">
                <div style="position: relative;">
                  <span id="clear-bayar"
                    style="
                                    position: absolute;
                                    left: 10px;
                                    top: 50%;
                                    transform: translateY(-50%);
                                    cursor: pointer;
                                    display: none;
                                    font-weight: bold;
                                    color: #888;
                                    z-index: 2;
                                    ">x</span>
                  <input type="text" id="input-bayar" name="bayar" class="form-control text-end"
                    style="padding-right: 10px" placeholder="Nominal Pembayaran">

                </div>

                <div id="btn-bayar-container">
                  <button type="button" class="btn btn-sm btn-primary mt-2 btn-bayar" data-nominal="10000">10k</button>
                  <button type="button" class="btn btn-sm btn-primary mt-2 btn-bayar" data-nominal="20000">20k</button>
                  <button type="button" class="btn btn-sm btn-primary mt-2 btn-bayar" data-nominal="30000">30k</button>
                  <button type="button" class="btn btn-sm btn-primary mt-2 btn-bayar" data-nominal="40000">40k</button>
                  <button type="button" class="btn btn-sm btn-primary mt-2 btn-bayar" data-nominal="50000">50k</button>
                  <button type="button" class="btn btn-sm btn-primary mt-2 btn-bayar" data-nominal="70000">70k</button>
                  <button type="button" class="btn btn-sm btn-primary mt-2 btn-bayar"
                    data-nominal="100000">100k</button>
                </div>
              </td>
            </tr>
            <tr class="pt-2 mt-2">
              <td>Kembali</td>
              <td id="kembali">Rp</td>
            </tr>
          </table>
          <div id="totals" data-total=""></div>
        </div>
      </div>
      <div class="btn-row d-flex align-items-center justify-content-between gap-3">
        <button type="button" class="btn btn-white d-flex align-items-center justify-content-center flex-fill m-0"
          id="btn-simpan"><i class="ti ti-save me-2"></i>Simpan Transaksi</button>
        <button type="submit" id="btn-selesai" data-transaksi=""
          class="btn btn-secondary d-flex align-items-center justify-content-center flex-fill m-0"><i
            class="ti ti-check me-2"></i>Selesaikan Transaksi</button>
      </div>
    </form>

  </aside>
</div>

<div class="modal fade modal-default" id="print-receipt" aria-labelledby="print-receipt">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <div class="icon-head text-center">
          <a href="javascript:void(0);">
            <img src="assets/img/logo.svg" width="100" height="30" alt="Receipt Logo"
              style="filter: grayscale(1);">
          </a>
        </div>
        <div class="text-center info text-center">
          <h6>{{ Session::get('toko.name') }}</h6>

        </div>
        <div id="tmp-print">
            
        </div>
        <div class="text-center invoice-bar">
          <div class="border-bottom border-dashed mb-3">
            <p>**Terimakasih telah berbelanja di Resto Kami. <br> Selamat Menikmati</p>
          </div>
          <div class="d-flex gap-2 justify-content-center text-center">
            <button class="btn btn-danger" onclick="location.reload();">Tutup</button>
            <a href="javascript:void(0);" class="btn btn-md btn-primary" id="btnPrintReceipt">Print Struk</a>
            {{-- <a href="javascript:void(0);" class="btn btn-md btn-success" id="btnDownloadPdf">Download PDF</a> --}}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
