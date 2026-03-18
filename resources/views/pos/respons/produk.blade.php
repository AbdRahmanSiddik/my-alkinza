@forelse  ($produk as $get)
  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 col-xxl-3">
    @php
      $isActive = in_array($get->id, $aktif) ? 'active' : '';
    @endphp
    <div class="product-info card mb-0 {{ $isActive }}">
      <a href="javascript:void(0);" class="pro-img">
        @if ($get->foto == null)
          <img src="{{ asset('gambar/produk/default.png') }}">
        @else
          <img src="{{ asset($get->foto) }}">
        @endif
        <span><i class="ti ti-circle-check-filled"></i></span>
      </a>
      <h6 class="cat-name"><a href="javascript:void(0);">{{ $get->kategori->name }}</a></h6>
      <h6 class="product-name"><a href="javascript:void(0);">{{ $get->name }}</a></h6>
      <div class="d-flex align-items-center justify-content-between price">
        <p class="text-gray-9 mb-0">@rupiah($get->harga)</p>
        <div class="qty-item m-0">
          @if ($isActive && $get->satuan == 'gram')
            <button type="button" data-id="{{ $get->id }}" data-harga="{{ $get->harga }}"
              class="btn btn-sm btn-primary tambah-item">Tambah</button>
            <i class="ti ti-tag me-1"></i>
          @elseif($isActive)
            <i class="ti ti-tag me-1"></i>
          @else
            <button type="button" data-id="{{ $get->id }}" data-harga="{{ $get->harga }}"
              class="btn btn-sm btn-primary tambah-item">Tambah</button>
          @endif
        </div>
      </div>
    <div class="d-flex align-items-center mt-2 justify-content-between">
      <small>/ {{ $get->satuan }}</small>
      @if ($get->status_stok == 'on')
        <small>{{ $get->stok }} tersedia</small>
      @else
        <small class="text-danger">Stok Diabaikan</small>
      @endif
    </div>
    </div>
  </div>
@empty
  <div class="col-12">
    <div class="alert alert-warning text-center" role="alert">
      Tidak ada produk pada kategori ini.
    </div>
  </div>
@endforelse
