@forelse ($transaksi as $get)
  <tr>
    <td>
      <div class="d-flex align-items-center">
        <a class="delete-icon" data-id="{{ $get->id }}" id="item-delete">
          <i class="ti ti-trash-x-filled"></i>
        </a>
        <h6 class="fs-13 fw-normal"><a href="#" class=" link-default" data-bs-toggle="modal"
            data-bs-target="#products">{{ $get->produk->name }}</a></h6>
      </div>
      <small>Harga / {{ $get->produk->satuan }} : <b>@rupiah($get->produk->harga)</b></small>
    </td>
    <td class="align-middle">
      @if ($get->produk->satuan == 'gram')
        <div class="input-group input-group-sm">
          <input type="text" inputmode="numeric" class="form-control text-center input-qty border-warning"
            id="qty-{{ $get->id }}" value="{{ $get->kuantitas }}" data-harga="{{ $get->subtotal }}"
            data-id="{{ $get->id }}" style="max-width: 100px">
        </div>
      @else
        <div class="input-group input-group-sm">
          <button type="button" class="btn btn-outline-primary btn-sm minus-qty" data-harga="{{ $get->subtotal }}"
            data-id="{{ $get->id }}">-</button>
          <input type="text" class="form-control text-center input-qty border-warning" id="qty-{{ $get->id }}"
            value="{{ $get->kuantitas }}" data-harga="{{ $get->subtotal }}" data-id="{{ $get->id }}"
            style="min-width: 30px;">
          <button type="button" class="btn btn-outline-primary btn-sm plus-qty" data-harga="{{ $get->subtotal }}"
            data-id="{{ $get->id }}">+</button>
        </div>
      @endif
    </td>
    <td class="fs-13 fw-semibold text-gray-9 text-end" id="tmp-harga-{{ $get->id }}">@rupiah($get->subtotal)</td>
  </tr>
@empty
  <tr>
    <td colspan="3" rowspan="3" class="text-center">
      <div class="">
        <div class="fs-24 mb-1">
          <i class="ti ti-shopping-cart"></i>
        </div>
        <p class="fw-bold">Belum ada produk di keranjang</p>
      </div>
    </td>
  </tr>
@endforelse
