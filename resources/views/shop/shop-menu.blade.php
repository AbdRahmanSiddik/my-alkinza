<x-landing>
  <!--=============================
        MENU PAGE START
    ==============================-->
  <section class="menu_page mt_100 xs_mt_70 mb_100 xs_mb_70">
    <div class="container" style="margin-top: 10rem">
      <div class="menu_search_area">
        <div class="row">
          <div class="col-lg-8 col-md-8">
            <div class="menu_search">
              <input type="text" id="search-input" placeholder="Cari Produk...">
            </div>
          </div>
          <div class="col-lg-4 col-md-4">
            <div class="menu_search">
              <div class="select_area">
                <select class="select_js" id="category-filter">
                  <option value="">Semua Kategori</option>
                  @foreach ($kategori as $id_kategori => $nama_kategori)
                    <option value="{{ $id_kategori }}" {{ request('kategori') == $id_kategori ? 'selected' : '' }}>
                      {{ $nama_kategori }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
      {{-- @dd(request()->routeIs('shop.menu'), request()->route('token_toko')) --}}

      <div class="row" id="produk-container">
        {{-- @include('shop._produk-list', ['produk' => $produk]) --}}
      </div>

    </div>
    <style>
      .bg-orange-custom {
        background-color: #ff7c08;
        /* Ganti dengan warna oranye yang sesuai */
      }

      .offcanvas-body .pro_name a {
        font-size: 14px;
        text-decoration: none;
      }

      .offcanvas-body .pro_tk h6,
      .offcanvas-body .pro_status h6 {
        font-size: 14px;
      }

      .cart-item .btn {
        width: 30px;
        height: 30px;
        padding: 0;
        font-size: 14px;
      }

      .cart-item {
        border-radius: 6px;
      }

      .btn-custom-orange {
        background-color: #ff7c08;
        border-color: #ff7c08;
      }

      .btn-custom-orange:hover,
      .btn-custom-orange:focus {
        background-color: #ff9941;
        border-color: #ff9941;
      }
    </style>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
      <div class="offcanvas-header bg-orange-custom">
        <h5 class="offcanvas-title text-white fw-bold m-0" id="cartOffcanvasLabel">Keranjang Belanja</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
          aria-label="Close"></button>
      </div>

      <div class="offcanvas-body">
        {{-- Item Keranjang akan dimuat di sini --}}
        <div id="tmp-keranjang"></div>
        {{-- @if (now()->format('H:i') >= '12:00' && now()->format('H:i') <= '22:00') --}}
        <form action="" class="mt-3" id="submit-pesanan" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="bukti-pembayaran" class="form-label">Bukti Pembayaran</label>
            <input type="file" class="form-control" id="bukti-pembayaran" name="bukti_pembayaran" accept="image/*">
            <div id="preview-bukti" class="mt-2"></div>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input form-control me-1" type="checkbox" value="ditempat" id="makan-ditempat"
              name="makan_ditempat" />
            <label class="form-check-label" for=""> Makan Ditempat? </label>

          </div>

          <div class="mb-3" id="meja-selection" style="display:none;">
            <label for="pilih-meja" class="form-label">Pilih Meja</label>
            <select class="form-select" id="pilih-meja" name="meja">
              <option value="">Pilih meja...</option>
              @foreach ($meja as $id => $nomor)
                <option value="{{ $id }}" {{ in_array($id, $activeMeja) ? 'disabled' : '' }}>
                  Meja {{ $nomor }} {{ in_array($id, $activeMeja) ? '(Sedang dipakai)' : '' }}
                </option>
              @endforeach
            </select>
          </div>
        </form>
        {{-- @else
          <div class="alert alert-warning mt-3 text-center">
            Toko masih tutup. Formulir pesanan akan tersedia saat toko buka jam 12:00 - 22:00.
          </div>
        @endif --}}

        @if ($shop->qris)
          <div class="text-center mt-4">
            <div class="fw-semibold mb-2">Scan QRIS untuk Pembayaran</div>
            <img src="{{ asset($shop->qris) }}" alt="QRIS" class="img-fluid rounded" style="max-width: 220px;">
          </div>
        @endif

      </div>

      <div class="offcanvas-footer p-3 border-top">
        <button
          class="btn btn-custom-orange text-white w-100 fw-semibold py-2 d-flex align-items-center justify-content-center gap-2"
          id="checkout-btn"
          {{-- {{ now()->format('H:i') < '12:00' || now()->format('H:i') > '22:00' ? 'disabled' : '' }} --}}
          >
          <i class="fas fa-shopping-basket"></i>
          <span class="text-white fw-bold">Checkout</span>
        </button>
        @if (now()->format('H:i') < '12:00' || now()->format('H:i') >= '22:00')
          <div class="text-danger mt-2 text-center small">Toko hanya buka jam 12:00 - 22:00</div>
        @endif
      </div>
    </div>
  </section>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      // Preview image bukti pembayaran
      $('#bukti-pembayaran').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function(e) {
            $('#preview-bukti').html(
              `<img src="${e.target.result}" alt="Preview" class="img-fluid rounded" style="max-height:150px;">`
            );
          }
          reader.readAsDataURL(file);
        } else {
          $('#preview-bukti').empty();
        }
      });

      // Checkbox makan di tempat, toggle meja selection
      $('#makan-ditempat').on('change', function() {
        if ($(this).is(':checked')) {
          $('#meja-selection').show();
        } else {
          $('#meja-selection').hide();
          $('#pilih-meja').val('');
        }
      });

      // Validasi jam pengambilan minimal 30 menit dari sekarang
      $('#jam-ambil').on('change', function() {
        const inputTime = new Date($(this).val());
        const now = new Date();
        const minTime = new Date(now.getTime() + 30 * 60000); // 30 menit dari sekarang
        if (inputTime < minTime) {
          $('#jam-ambil-error').text('Jam pengambilan minimal 30 menit dari sekarang!').show();
          $(this).val('');
        } else {
          $('#jam-ambil-error').hide();
        }
      });
      let typingTimer;
      const typingInterval = 300;

      $('#category-filter').on('change', function() {
        filterProduk();
      });

      $('#search-input').on('keyup', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(filterProduk, typingInterval);
      });

      filterProduk();

      function filterProduk() {
        let kategoriId = $('#category-filter').val();
        let searchQuery = $('#search-input').val();
        let tokenToko = "{{ $shop->token_toko }}";
        let url = `/menu/${tokenToko}`;

        $.ajax({
          url: url,
          type: 'GET',
          data: {
            kategori: kategoriId,
            search: searchQuery
          },
          success: function(response) {
            $('#produk-container').html(response.html);
          },
          error: function(xhr) {
            // console.log(xhr.responseText);
            alert('Gagal memuat produk.');
          }
        });
      }

    @if (Auth::check() && request()->routeIs('shop.menu'))
      function loadCart() {
        $.ajax({
        url: "{{ url('/shop/get-data-keranjang') }}",
        type: 'GET',
        dataType: 'json',
        data: {
          toko: '{{ request()->route('token_toko') }}'
        },
        success: function(data) {
          $('#tmp-keranjang').html(data.html);
          $('#items').text(data.count || 0);
        },
        error: function(xhr) {
          alert('Gagal memuat keranjang belanja.');
          console.error(xhr.responseText);
        }
        });
      }
      loadCart();

      $(document).on('click', '#btn-keranjang', function() {
        let produkId = $(this).data('id');
        const tokenToko = "{{ request()->route('token_toko') }}";
        $.ajax({
        url: "{{ url('/shop/add-to-cart') }}",
        type: 'POST',
        data: {
          produk_id: produkId,
          _token: '{{ csrf_token() }}',
          toko: tokenToko
        },
        success: function(response) {
          loadCart();
          filterProduk();
          alert('Produk berhasil ditambahkan ke keranjang.');
        },
        error: function(xhr) {
          alert('Gagal menambahkan produk ke keranjang.');
          console.error(xhr.responseText);
        }
        });
      });

      function updateCartItem(id, action) {
        const tokenToko = "{{ request()->route('token_toko') }}";
        $.ajax({
        url: "{{ url('/shop/update-cart-item') }}",
        type: 'POST',
        data: {
          id: id,
          action: action,
          toko: tokenToko,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          loadCart();
          filterProduk();
          alert('Item keranjang berhasil diperbarui.' + response.aksi);
        },
        error: function(xhr) {
          alert('Gagal memperbarui item keranjang.');
          console.error(xhr.responseText);
        }
        });
      }

      $(document).off('click', '.btn-plus');
      $(document).off('click', '.btn-minus');
      $(document).off('click', '.btn-delete');

      $(document).on('click', '.btn-plus', function() {
        let id = $(this).data('id');
        updateCartItem(id, 'plus');
      });
      $(document).on('click', '.btn-minus', function() {
        let id = $(this).data('id');
        updateCartItem(id, 'minus');
      });
      $(document).on('click', '.btn-delete', function() {
        let id = $(this).data('id');
        if (confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) {
        updateCartItem(id, 'delete');
        }
      });

      $('#checkout-btn').on('click', function() {
        if (!confirm('Apakah Anda yakin ingin melakukan checkout pesanan ini?')) {
        return;
        }
        let formData = new FormData($('#submit-pesanan')[0]);
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('toko', '{{ request()->route('token_toko') }}');
        formData.append('file', $('#bukti-pembayaran')[0].files[0]);
        // Pastikan semua data form, termasuk file dan select value, dikirim
        // Jika checkbox "makan ditempat" dicentang, tambahkan nilai meja (jika ada)
        if ($('#makan-ditempat').is(':checked')) {
        formData.set('makan_ditempat', 'ditempat');
        formData.set('meja', $('#pilih-meja').val());
        } else {
        formData.delete('meja');
        formData.delete('makan_ditempat');
        }

        $.ajax({
        url: "{{ url('/shop/checkout') }}",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          alert('Pesanan berhasil dibuat!');
        //   window.location.href = "{{ url('/shop/orders/' . $shop->token_toko) }}";
        //   console.log(response);
        loadCart();
        filterProduk();
        window.location.href = "{{ url('/pesanan/' . $shop->token_toko) }}";
        },
        error: function(xhr) {
          if (xhr.status === 422) {
            let errors = xhr.responseJSON.errors;
            let errorMessages = Object.values(errors).map(errArray => errArray.join(' ')).join('\n');
            alert('Terjadi kesalahan:\n' + errorMessages);
          } else {
            alert('Gagal melakukan checkout. Silakan coba lagi.');
          }
          console.error(xhr.responseText);
        }
        });
      });
      @endif

    });
  </script>

</x-landing>
