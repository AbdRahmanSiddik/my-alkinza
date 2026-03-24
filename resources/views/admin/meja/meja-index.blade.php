<x-admin-panel>
  <div class="page-header">
    <div class="add-item d-flex">
      <div class="page-title">
        <h4 class="fw-bold">Data Meja</h4>
        <h6>Manage Meja Anda</h6>
      </div>
    </div>
    <ul class="table-top-head">
      <li>
        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf">
          <img src="{{ asset('assets/img/icons/pdf.svg') }}" alt="img">
        </a>
      </li>
      <li>
        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel">
          <img src="{{ asset('assets/img/icons/excel.svg') }}" alt="img">
        </a>
      </li>
      <li>
        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
            class="ti ti-chevron-up"></i></a>
      </li>
    </ul>
    <div class="page-btn d-flex align-items-center gap-2">
      <a href="javascript:void(0);" class="btn btn-primary d-flex align-items-center gap-1" data-bs-toggle="modal"
        data-bs-target="#tambahMeja">
        <i class="ti ti-circle-plus me-1"></i>
        Tambah Meja
      </a>
      <a href="javascript:void(0);" class="btn btn-danger d-flex align-items-center gap-1" data-bs-toggle="modal"
        data-bs-target="#kurangiMeja">
        <i class="ti ti-square-rounded-minus"></i>
        Kurangi Meja
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
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table datatable">
          <thead class="thead-light">
            <tr>
              <th>No.</th>
              <th>Kode Meja</th>
              <th>Nomor Meja</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($mejas as $index => $item)
              <tr>
                <td>{{ $index + 1 }}.</td>
                <td>{{ $item->kode_meja }}</td>
                <td>{{ $item->nomor_meja }}</td>
              </tr>
            @empty
              {{-- <tr>
                <td colspan="3" class="text-center">Tidak ada data Meja</td>
              </tr> --}}
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- /product list -->

  <!-- Modal Kurangi Meja -->
  <div class="modal fade modal-sweet" id="kurangiMeja" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-center">
        <div class="modal-body p-4">

          @php
            $mejaTerakhir = \App\Models\Meja::where('toko_id', session('toko.id'))->orderByDesc('nomor_meja')->first();
          @endphp

          @if ($mejaTerakhir)
            <span class="rounded-circle d-inline-flex p-2 bg-danger-transparent mb-3">
              <i class="ti ti-trash fs-24 text-danger"></i>
            </span>
            <h4 class="fs-20 fw-semibold">Yakin Ingin Menghapus?</h4>
            <p class="text-muted mb-3">Meja <strong>{{ $mejaTerakhir->nomor_meja }}</strong> akan dihapus secara
              permanen.</p>

            <form action="{{ route('meja.destroy', $mejaTerakhir->token_meja) }}" method="POST">
              @csrf
              @method('DELETE')
              <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-danger">Ya, Hapus</button>
            </form>
          @else
            <span class="rounded-circle d-inline-flex p-2 bg-warning-transparent mb-3">
              <i class="ti ti-alert-circle fs-24 text-warning"></i>
            </span>
            <h4 class="fs-20 fw-semibold">Tidak Ada Meja</h4>
            <p class="text-muted mb-0">Belum ada meja yang bisa dihapus.</p>
            <div class="mt-3">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
          @endif

        </div>
      </div>
    </div>
  </div>

  @include('admin.meja.form-create')

</x-admin-panel>
