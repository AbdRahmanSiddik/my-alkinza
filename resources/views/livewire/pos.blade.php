<div>
    <div class="row pos-wrapper">

        <!-- Products -->
        <div class="col-md-12 col-lg-7 col-xl-8 d-flex">
            <div class="pos-categories tabs_wrapper p-0 flex-fill">
                <div class="content-wrap">
                    <div class="tab-wrap" wire:ignore>
                        <ul class="tabs owl-carousel pos-category5">
                            <li id="all" class="active" onclick="setCategory('all')">
                                <a href="javascript:void(0);">
                                    <img alt="Categories" data-cfsrc="{{ Session::get('toko.logo') }}"
                                        style="display:none;visibility:hidden;"><noscript><img
                                            src="{{ Session::get('toko.logo') }}" alt="Categories"></noscript>
                                </a>
                                <h6><a href="javascript:void(0);">Semua</a></h6>
                            </li>
                            @foreach ($categories as $cat)
                                <li id="{{ $cat->token_kategori }}" onclick="setCategory('{{ $cat->token_kategori }}')">
                                    <a href="javascript:void(0);">
                                        <img alt="Categories" data-cfsrc="{{ asset($cat->icon) }}"
                                            style="display:none;visibility:hidden;"><noscript><img
                                                src="{{ asset($cat->icon) }}" alt="Categories"></noscript>
                                    </a>center
                                    <h6><a href="javascript:void(0);">{{ $cat->name }}</a></h6>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="tab-content-wrap">
                        <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
                            <div class="mb-3">
                                <h5 class="mb-1">Welcome, {{ Auth::user()->name }}</h5>
                                <p>{{ \Carbon\Carbon::now('Asia/Jakarta')->format('F d, Y') }}</p>
                            </div>
                            <div class="d-flex align-items-center flex-wrap mb-2">
                                <div class="input-icon-start search-pos position-relative mb-2 me-3">
                                    <span class="input-icon-addon">
                                        <i class="ti ti-search"></i>
                                    </span>
                                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                                        placeholder="Search Product">
                                </div>
                            </div>
                        </div>
                        <div class="pos-products">
                            <div class="row g-3">

                                @forelse ($products as $product)
                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 col-xxl-3">
                                        <div
                                            class="product-info card mb-0 {{ collect($cartProductIds)->contains($product->id) ? 'active' : '' }}">
                                            <a href="javascript:void(0);" class="pro-img">
                                                <img src="{{ asset($product->foto ?? 'gambar/produk/default.png') }}"
                                                    alt="{{ $product->name }}">
                                                <span><i class="ti ti-circle-check-filled"></i></span>
                                            </a>

                                            <h6 class="cat-name">{{ $product->kategori->name }}</h6>
                                            <div class=" justify-content-between">
                                                <h6 class="product-name">{{ $product->name }}</h6>
                                                @if ($product->status_stok == 'on')
                                                    <small
                                                        class="{{ $product->stok == 0 ? 'text-danger' : 'text-success' }}">{{ $product->stok }}</small>
                                                @else
                                                    <small>Stok: <span class="text-danger">off</span></small>
                                                @endif
                                            </div>

                                            <div class="d-flex align-items-center justify-content-between price">
                                                <p class="text-gray-9 mb-0">@rupiah($product->harga) <small>/
                                                        {{ $product->satuan }}</small></p>
                                                @if (collect($cartProductIds)->contains($product->id) && in_array($product->satuan, ['pcs', 'porsi']))
                                                    <button class="btn btn-sm btn-outline-secondary" disabled>
                                                        <i class="ti ti-check"></i>
                                                    </button>
                                                @else
                                                    <button
                                                        wire:click.prevent="addToCart('{{ $product->token_product }}')"
                                                        wire:loading.attr="disabled" wire:target="addToCart"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="ti ti-plus"></i>
                                                    </button>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="alert alert-warning mb-0">
                                            @if ($activeCategory === 'all')
                                                Produk yang kamu cari tidak ditemukan
                                            @else
                                                Produk tidak ditemukan di kategori ini
                                            @endif
                                        </div>
                                    </div>
                                @endforelse

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- /Products -->

        <!-- Order Details -->
        <div class="col-md-12 col-lg-5 col-xl-4 ps-0 theiaStickySidebar">
            <aside class="product-order-list bg-secondary-transparent flex-fill w-100">
                <div class="card">
                    <div class="card-body">
                        <div class="order-head d-flex align-items-center justify-content-between w-100">
                            <div>
                                <h3>Order List</h3>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span
                                    class="badge badge-dark fs-10 fw-medium badge-xs">#{{ $keranjang->kode_transaksi ?? 'null' }}</span>
                                {{-- <a class="link-danger fs-16" href="javascript:void(0);"><i
                                        class="ti ti-trash-x-filled"></i></a> --}}
                            </div>
                        </div>
                        <div class="customer-info block-section">
                            <h5 class="mb-2">Nama Customer <small>(Optional)</small></h5>
                            <div class="d-flex align-items-center gap-2">
                                <div class="flex-grow-1">
                                    <input type="text" class="form-control" placeholder="Customer Name (Optional)"
                                        wire:model="customerName">
                                </div>
                            </div>
                        </div>
                        <div class="product-added block-section">
                            <div class="head-text d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <h5 class="me-2">Order Details</h5>
                                    <div class="badge bg-light text-gray-9 fs-12 fw-semibold py-2 border rounded">
                                        Items : <span
                                            class="text-teal">{{ $keranjang?->produkPivot?->count() ?? 0 }}</span>
                                    </div>
                                </div>
                                @if ($keranjang && $keranjang->produkPivot->isNotEmpty())
                                    <a href="javascript:void(0);" data-bs-toggle="modal"
                                        data-bs-target="#clearCartModal"
                                        class="d-flex align-items-center clear-icon fs-10 fw-medium">Clear all</a>

                                    <div class="modal fade" id="clearCartModal" tabindex="-1"
                                        aria-labelledby="clearCartModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="clearCartModalLabel">Konfirmasi Hapus
                                                        Keranjang</h5>
                                                    <button type="button" class="close bg-danger text-white fs-16"
                                                        data-bs-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-danger text-center">
                                                    Apakah Anda yakin ingin mengosongkan keranjang? Tindakan ini tidak
                                                    dapat dikembalikan.
                                                </div>
                                                <div class="modal-footer gap-2">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Tidak, Batal</button>
                                                    <button type="button" class="btn btn-primary"
                                                        wire:click="clearCart" data-bs-dismiss="modal">Ya, Hapus
                                                        Keranjang</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="product-wrap">
                                @if ($keranjang && $keranjang->produkPivot->isNotEmpty())
                                    <div class="product-list border-0 p-0">
                                        <div class="table-responsive">
                                            <table class="table table-borderless">
                                                <thead>
                                                    <tr>
                                                        <th class="fw-bold bg-light">Item</th>
                                                        <th class="fw-bold bg-light">QTY</th>
                                                        <th class="fw-bold bg-light text-end">Cost</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($keranjang?->produkPivot ?? [] as $item)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <a class="delete-icon" href="javascript:void(0);"
                                                                        wire:click="removeItem('{{ $item->id }}')">
                                                                        <i class="ti ti-trash-x-filled"></i>
                                                                    </a>
                                                                    <div>
                                                                        <h6 class="fs-13 fw-normal">
                                                                            {{ $item->produk->name }}
                                                                        </h6>
                                                                        <small
                                                                            class="fs-12 text-gray-9 fw-medium d-flex align-items-center gap-1">
                                                                            @rupiah($item->produk->harga) /
                                                                            {{ $item->produk->satuan }}
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="qty-item m-0">
                                                                    @if ($item->produk->satuan !== 'gram')
                                                                        <a href="javascript:void(0);"
                                                                            class="dec d-flex justify-content-center align-items-center {{ $item->kuantitas == 1 ? 'disabled opacity-50 text-danger' : '' }}"
                                                                            @if ($item->kuantitas > 1) wire:click="decreaseQty('{{ $item->id }}')" @endif
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-placement="top" title="minus"
                                                                            @if ($item->kuantitas == 1) style="pointer-events: none;" @endif><i
                                                                                class="ti ti-minus"></i></a>
                                                                        <input type="text"
                                                                            class="form-control text-center"
                                                                            name="qty"
                                                                            value="{{ $item->kuantitas }}" readonly>
                                                                        <a href="javascript:void(0);"
                                                                            class="inc d-flex justify-content-center align-items-center {{ $item->produk->stok == 0 && $item->produk->status_stok == 'on' ? 'disabled opacity-50 text-danger' : '' }}"
                                                                            @if ($item->produk->status_stok == 'off' || ($item->produk->status_stok == 'on' && $item->produk->stok > 0)) wire:click="increaseQty('{{ $item->id }}')" @endif
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-placement="top" title="plus"
                                                                            @if ($item->produk->stok == 0 && $item->produk->status_stok == 'on') style="pointer-events: none;" @endif><i
                                                                                class="ti ti-plus"></i></a>
                                                                    @else
                                                                        <input type="text" inputmode="numeric"
                                                                            class="form-control form-control-sm text-center bg-secondary-transparent"
                                                                            wire:model.live.debounce.300ms="gramasi.{{ $item->id }}"
                                                                            placeholder="gram"
                                                                            value="{{ $item->kuantitas }}"
                                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td class="fs-13 fw-semibold text-gray-9 text-end">
                                                                @rupiah($item->subtotal)</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-light text-center border" role="alert">
                                        <div class="mb-2 fs-3 text-muted">
                                            <i class="ti ti-shopping-cart"></i>
                                        </div>
                                        <strong>No Products Selected</strong>
                                        <div class="text-muted small">
                                            Pilih produk untuk mulai transaksi
                                        </div>
                                    </div>

                                @endif
                            </div>
                        </div>
                        <div class="order-total bg-total bg-white border-top border-dashed pt-3 mt-3 block-section">
                            <h5 class="mb-3">Payment Summary</h5>

                            {{-- subtotal --}}
                            <div class="d-flex justify-content-between mb-2 small">
                                <span>Sub Total</span>
                                <span class="text-gray-9">@rupiah($this->subtotal)</span>
                            </div>

                            {{-- total --}}
                            <div class="d-flex justify-content-between fw-bold border-top border-dashed pt-2 mb-2">
                                <span>Total Tagihan</span>
                                <span class="text-gray-9">@rupiah($this->totalPayable)</span>
                            </div>

                            {{-- metode bayar --}}
                            <div class="d-flex flex-wrap gap-3 mb-2">
                                <label class="form-check">
                                    <input class="form-check-input" type="radio"
                                        wire:model.live.debounce.300ms="paymentMethod" value="tunai">
                                    Tunai
                                </label>

                                <label class="form-check">
                                    <input class="form-check-input" type="radio"
                                        wire:model.live.debounce.300ms="paymentMethod" value="non-tunai">
                                    Non Tunai
                                </label>
                            </div>

                            @if ($paymentMethod === 'tunai')

                                {{-- input tunai --}}
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Tunai</span>
                                    <input type="text" inputmode="numeric"
                                        class="form-control form-control-sm text-end w-50" placeholder="0"
                                        wire:model.live.debounce.500ms="cash">
                                </div>

                                {{-- tombol cash --}}
                                <div class="d-flex flex-wrap gap-1 justify-content-end mb-2">
                                    <button class="btn btn-primary btn-sm" wire:click="addCash(10000)">10k</button>
                                    <button class="btn btn-primary btn-sm" wire:click="addCash(20000)">20k</button>
                                    <button class="btn btn-primary btn-sm" wire:click="addCash(25000)">25k</button>
                                    <button class="btn btn-primary btn-sm" wire:click="addCash(50000)">50k</button>
                                    <button class="btn btn-primary btn-sm" wire:click="addCash(60000)">60k</button>
                                    <button class="btn btn-primary btn-sm" wire:click="addCash(70000)">70k</button>
                                    <button class="btn btn-primary btn-sm" wire:click="addCash(75000)">75k</button>
                                    <button class="btn btn-primary btn-sm" wire:click="addCash(80000)">80k</button>
                                    <button class="btn btn-primary btn-sm" wire:click="addCash(90000)">90k</button>
                                    <button class="btn btn-primary btn-sm" wire:click="addCash(100000)">100k</button>

                                    <button class="btn btn-danger btn-sm px-2" wire:click="clearCash()">
                                        <i class="ti ti-trash-x-filled"></i>
                                    </button>
                                </div>

                                {{-- kembalian --}}
                                <div class="d-flex justify-content-between fw-bold border-top pt-2">
                                    <span>Kembalian</span>
                                    <span class="{{ $this->kembalian > 0 ? 'text-success' : 'text-danger' }}">
                                        @if ($this->cash == 0 || $this->cash < $this->totalPayable)
                                            pembayaran belum cukup
                                        @else
                                            @rupiah($this->kembalian)
                                        @endif
                                    </span>
                                </div>

                            @endif
                        </div>


                    </div>
                </div>
                <div class="btn-row d-flex align-items-center justify-content-between gap-3">
                    <a href="javascript:void(0);"
                        class="btn btn-white d-flex align-items-center justify-content-center flex-fill m-0"
                        wire:click="placeOrder('pending')"><i class="ti ti-shopping-cart me-2"></i>Simpan Order
                        Sementara</a>
                    <a href="javascript:void(0);" wire:click="placeOrder('selesai')"
                        @if ($paymentMethod === 'tunai' && ($this->cash == 0 || $this->cash < $this->totalPayable)) disabled style="pointer-events: none; opacity: 0.5;" @endif
                        class="btn btn-secondary d-flex align-items-center justify-content-center flex-fill m-0"><i
                            class="ti ti-printer me-2"></i>Selesaikan Order</a>
                </div>
            </aside>
        </div>
        <!-- /Order Details -->

    </div>

    <div wire:ignore.self class="modal fade" id="print-receipt" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body">
                    <div id="receipt-content">
                        {{-- DATA STRUK DIINJECT VIA AJAX --}}
                        <div class="text-center text-muted py-4">
                            Memuat struk...
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-center mt-3">
                        <button class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-primary" id="btnPrintReceipt">
                            Print Struk
                        </button>
                        <a href="#" id="btnPrintAndroid" class="btn btn-sm btn-success d-none">
                            <i class="fab fa-android me-1"></i> Print Android
                        </a>
                        <a role="button" id="btnPrintFull" class="btn btn-sm btn-primary d-none">
                            <i class="fas fa-print me-1"></i> Print Lengkap
                        </a>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <iframe id="print-frame" style="display:none;"></iframe>


    <div wire:ignore.self class="modal fade" id="pending-transactions" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <h5 class="modal-title">Transaksi Tertunda</h5>
                    <div class="px-3 pt-3">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" wire:model.live.debounce.300ms="searchPending" class="form-control"
                                placeholder="Cari nama / kode transaksi...">
                        </div>
                    </div>
                </div>
                <div class="modal-body pt-2">

                    @forelse ($pendingTransactions as $item)
                        <div class="border rounded p-3 mb-2 shadow-sm">

                            <div class="d-flex justify-content-between align-items-center">

                                {{-- LEFT INFO --}}
                                <div class="flex-grow-1">

                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span class="fw-semibold">
                                            {{ $item->nama_pelanggan ?? 'Pelanggan Umum' }}
                                        </span>

                                        <small class="text-muted">
                                            #{{ $item->kode_transaksi }}
                                        </small>
                                    </div>

                                    <div class="d-flex gap-3 small text-muted">
                                        <span>Qty : {{ $item->kuantitas ?? 0 }}</span>
                                        <span>Bayar : @rupiah($item->bayar ?? 0)</span>
                                        <span>Kembali : @rupiah($item->kembali ?? 0)</span>
                                    </div>

                                    <div class="fw-semibold text-primary mt-1">
                                        Total : @rupiah($item->subtotal)
                                    </div>

                                </div>

                                {{-- ACTION --}}
                                <div class="d-flex flex-column gap-1 text-end ms-3">

                                    <button class="btn btn-sm btn-success"
                                        wire:click="restoreTransaction({{ $item->id }})">
                                        <i class="fas fa-undo me-1"></i> Lanjutkan
                                    </button>

                                    <button class="btn btn-sm btn-outline-danger"
                                        wire:click="deleteTransaction({{ $item->id }})">
                                        <i class="fas fa-trash me-1"></i> Batalkan
                                    </button>

                                </div>

                            </div>

                        </div>

                    @empty
                        <div class="text-center py-4 alert alert-light border rounded">
                            <i class="fas fa-inbox mb-2 d-block fs-4 text-muted"></i>
                            <p class="mb-0 text-muted">
                                Tidak ada transaksi tertunda yang ditemukan
                            </p>
                        </div>
                    @endforelse

                </div>



                <div class="modal-footer">
                    <button class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                </div>

            </div>
        </div>
    </div>

    <script>
        function setCategory(token) {
            Livewire.dispatch('setCategory', token);
        }
    </script>
    <script>
        document.addEventListener('click', function(e) {
            if (e.target.id !== 'btnPrintReceipt') return;

            const content = document.getElementById('tmp-print').outerHTML;
            const iframe = document.getElementById('print-frame');
            const doc = iframe.contentWindow.document;

            doc.open();
            doc.write(`
                <html>
                <head>
                <title>Print Struk</title>
                <style>
                @page {
                    size: 58mm auto; /* ganti 80mm kalau printer 80 */
                    margin: 0;
                }

                html, body {
                    margin: 0;
                    padding: 0;
                }

                body {
                    font-family: Arial, sans-serif;
                    font-size: 12px;
                }

                /* INI YANG PENTING */
                .receipt {
                    width: 58mm; /* HARUS sama dengan @page */
                    padding: 5mm;
                    box-sizing: border-box;
                }

                /* table full width */
                table {
                    width: 100%;
                    border-collapse: collapse;
                }

                td, th {
                    padding: 2px 0;
                    font-size: 12px;
                    vertical-align: top;
                }

                .text-end {
                    text-align: right;
                }

                .text-center {
                    text-align: center;
                }

                /* QR & logo jangan bikin layout nyempit */
                img {
                    max-width: 100%;
                    height: auto;
                    display: block;
                    margin: 0 auto 4px;
                }

                h6 {
                    margin: 4px 0;
                    font-size: 13px;
                }

                hr {
                    border: none;
                    border-top: 1px dashed #000;
                    margin: 6px 0;
                }
                </style>


                </head>
                <body>
                ${content}
                </body>
                </html>
            `);
            doc.close();

            setTimeout(() => {
                iframe.contentWindow.focus();
                iframe.contentWindow.print();
            }, 300);
        });
    </script>
</div>
