<!-- Modal Tambah Meja -->
<div class="modal fade modal-sweet" id="tambahMeja" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-body p-4">
        <span class="rounded-circle d-inline-flex p-2 bg-primary-transparent mb-3">
          <i class="ti ti-layout-grid fs-24 text-primary"></i>
        </span>
        <h4 class="fs-20 fw-semibold">Tambah Meja Baru?</h4>
        <p class="text-muted mb-3">
          Apakah Anda yakin ingin <strong>menambah 1 meja baru</strong>?<br>
          Nomor dan kode meja akan ditentukan otomatis oleh sistem.
        </p>

        <form action="{{ route('meja.store') }}" method="POST">
          @csrf
          <div class="d-flex justify-content-center gap-2">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Tambah Meja</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
