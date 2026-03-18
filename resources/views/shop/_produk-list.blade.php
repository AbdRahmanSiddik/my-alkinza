@forelse ($produk as $item)
    <div class="col-6 col-sm-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-duration="1s">
        <div class="menu_item">
            <div class="menu_item_img">
                <img src="{{ asset($item->foto ?? 'assets/img/download-img.png') }}" alt="{{ $item->name }}"
                    class="img-fluid w-100">
            </div>
            <div class="menu_item_text">
                <a class="category" href="#">{{ $item->kategori->name ?? '-' }}</a>
                <a class="title" href="#">{{ $item->name }}</a>
                <h5 class="price mb-5">Rp{{ number_format($item->harga, 0, ',', '.') }}</h5>
                @php
                    $isAdded = isset($activeProduk) && in_array($item->id, $activeProduk);
                @endphp
                @auth
                    <a class="add_to_cart mt-5 {{ $isAdded ? 'disabled' : '' }}" role="button" id="btn-keranjang" data-id="{{ $item->id }}"
                         {{ $isAdded ? 'aria-disabled=true tabindex=-1 style=pointer-events:none;opacity:0.6;' : '' }}>
                        {{ $isAdded ? 'ditambahkan' : '+ keranjang' }}
                    </a>
                @endauth

                @guest
                    <a class="add_to_cart mt-5" href="{{ route('login') }}">
                        + Keranjang
                    </a>
                @endguest

            </div>
        </div>
    </div>
@empty
    <div class="col-12 text-center py-5">
        <img src="{{ asset('regfood/assets/images/nodata.png') }}" alt="Tidak ada produk" class="mb-3" style="max-width: 210px;">
        <h5 class="text-muted">Produk tidak tersedia</h5>
    </div>
@endforelse
