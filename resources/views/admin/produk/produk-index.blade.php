<x-admin-panel>
  <div class="page-header">
    <div class="add-item d-flex">
      <div class="page-title">
        <h4 class="fw-bold">List Produk</h4>
        <h6>Kelola produk Anda</h6>
      </div>
    </div>
    <ul class="table-top-head">
      <li>
        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf"><img src="assets/img/icons/pdf.svg"
            alt="img"></a>
      </li>
      <li>
        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel"><img src="assets/img/icons/excel.svg"
            alt="img"></a>
      </li>
      <li>
        <a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i
            class="ti ti-refresh"></i></a>
      </li>
      <li>
        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
            class="ti ti-chevron-up"></i></a>
      </li>
    </ul>
    <div class="page-btn">
      <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-modal">
        <i class="ti ti-circle-plus me-1"></i>
        Tambah Produk
      </a>
    </div>
  </div>

  <!-- /product list -->
  <div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
      <div class="search-set">
        <div class="search-input">
          <span class="btn-searchset"><i class="ti ti-search fs-14 feather-search"></i></span>
        </div>
      </div>
      <div class="d-flex table-dropdown my-xl-auto right-content align-items-center flex-wrap row-gap-3">
        <div class="dropdown me-2">
          <a href="javascript:void(0);" class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center"
            data-bs-toggle="dropdown">
            Kategori
          </a>
          <ul class="dropdown-menu  dropdown-menu-end p-3">
            @foreach ($categories as $cat)
              <li>
                <a href="?cat={{ $cat->token_kategori }}" class="dropdown-item rounded-1">{{ $cat->name }}</a>
              </li>
            @endforeach

          </ul>
        </div>
        <a href="{{ route('produk.index') }}" class="btn btn-danger">Clear</a>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table datatable">
          <thead class="thead-light">
            <tr>
              <th>Nama Produk</th>
              <th>Kategori</th>
              <th>Harga</th>
              <th>Unit</th>
              <th>Stok</th>
              <th class="no-sort"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($products as $item)
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <a href="javascript:void(0);" class="avatar avatar-md me-2">
                      <img alt="product" data-cfsrc="{{ asset($item->foto ?? 'gambar/produk/default.png') }}"
                        style="display:none;visibility:hidden;"><noscript><img
                          src="{{ asset($item->foto ?? 'gambar/produk/default.png') }}" alt="product"></noscript>
                    </a>
                    <a href="javascript:void(0);">{{ $item->name }} </a>
                  </div>
                </td>
                <td>{{ $item->kategori->name }}</td>
                <td>@rupiah($item->harga)</td>
                <td>{{ $item->satuan }}</td>
                <td>
                  @if ($item->status_stok == 'off')
                    <span class="badge bg-secondary">Off</span>
                  @else
                    {{ $item->stok }}
                  @endif
                </td>
                <td class="action-table-data">
                  <div class="edit-delete-action">
                    <a class="me-2 edit-icon  p-2" href="product-details.html">
                      <i data-feather="eye" class="feather-eye"></i>
                    </a>
                    <a class="me-2 p-2" role="button" data-bs-toggle="modal" data-bs-target="#edit-modal{{ $item->token_product }}">
                      <i data-feather="edit" class="feather-edit"></i>
                    </a>
                    <a href="javascript:void(0);" class="p-2 text-danger" data-bs-toggle="tooltip"
                      data-bs-placement="top" title="Hapus Produk"
                      onclick="confirmDelete('{{ route('produk.destroy', $item->token_product) }}', '{{ addslashes($item->name) }}')">
                      <i data-feather="trash-2" class="feather-trash-2"></i>
                    </a>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  @include('admin.produk.modal-create')
  @include('admin.produk.modal-edit')

  <!-- /product list -->
</x-admin-panel>
