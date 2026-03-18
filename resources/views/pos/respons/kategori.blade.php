<li id="all" class="item kategori-item active" data-bs-toggle="tooltip" data-bs-placement="right" aria-label="plus"
  data-bs-original-title="Semua Produk" data-id="all">
  <a href="javascript:void(0);">
      <img alt="Categories" src="{{ asset(Session::get('toko.logo')) }}" style="max-width: 100%;">
    </a>
  <h6><a href="#">Semua</a></h6>
</li>
@foreach ($kategori as $get)

  <li class="item kategori-item text-center" style="width: 100%;" data-bs-toggle="tooltip"
    data-bs-placement="right" aria-label="plus" data-bs-original-title="{{ $get->name }}" id="{{ $get->id }}"
    data-id="{{ $get->id }}">
    <a href="javascript:void(0);">
      <img alt="Categories" src="{{ asset($get->icon) }}" style="max-width: 100%;">
    </a>
    <h6 class="m-0" style="white-space: normal; word-wrap: break-word; overflow-wrap: break-word;">
      <a href="javascript:void(0);" class="d-block">{{ $get->name }}</a>
    </h6>
  </li>
@endforeach
