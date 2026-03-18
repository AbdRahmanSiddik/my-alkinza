{{-- Item Keranjang --}}
@forelse ($keranjang?->produkPivot ?? [] as $item)
  <div class="cart-item d-flex align-items-center justify-content-between border-bottom py-3 px-2 gap-2">

    {{-- Nama & Harga Satuan --}}
    <div class="flex-grow-1" style="min-width: 140px;">
        <a role="button" style="display: inline-block;" class="text-danger btn-delete" data-id="{{ $item->id }}"><i class="far fa-times-circle fs-5"></i></a>
      <a href="#" class="fw-semibold text-dark d-block">{{ $item->produk->name }}</a>
      <small class="text-muted">@rupiah($item->produk->harga)/{{ $item->produk->satuan }}</small>
    </div>

    {{-- Quantity Control --}}
    <div class="d-flex align-items-center">
      <button class="btn btn-sm btn-custom-orange rounded-circle text-white btn-minus" data-id="{{ $item->id }}"><i class="fas fa-minus"></i></button>
      <input type="text" class="form-control form-control-sm text-center mx-1" value="{{ $item->kuantitas }}"
        style="width: 45px;">
      <button class="btn btn-sm btn-custom-orange rounded-circle text-white btn-plus" data-id="{{ $item->id }}"><i class="fas fa-plus"></i></button>
    </div>

    {{-- Total Harga --}}
    <div class="text-end" style="width: 80px;">
      <span class="fw-semibold text-nowrap">@rupiah($item->subtotal)</span>
    </div>

    {{-- Remove Button --}}
    {{-- <div class="text-end" style="width: 30px;">

    </div> --}}
  </div>
@empty
  <div class="text-center text-muted py-4">Keranjang masih kosong.</div>
@endforelse
{{-- Tambahkan item lain di bawahnya dengan struktur yang sama --}}
