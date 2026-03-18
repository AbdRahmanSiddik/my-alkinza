<!-- Modal Create -->
<div class="modal fade" id="tambahKas">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="page-title">
          <h4>Form Tambah Kas</h4>
        </div>
        <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <form action="{{ route('kas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nama Kas<span class="text-danger ms-1">*</span></label>
            <input type="text" name="nama_kas" class="form-control" required placeholder="Masukkan nama kas">
          </div>
          <div class="mb-3">
            <label class="form-label">Jenis Kas<span class="text-danger ms-1">*</span></label>
            <div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="jenis_kas" id="radioPemasukan" value="pemasukan">
                <label class="form-check-label" for="radioPemasukan">Pemasukan</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="jenis_kas" id="radioPengeluaran"
                  value="pengeluaran">
                <label class="form-check-label" for="radioPengeluaran">Pengeluaran</label>
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Nominal Kas<span class="text-danger ms-1">*</span></label>
            <input type="number" name="nominal_kas" class="form-control" required placeholder="Masukkan nominal kas"
              min="0" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
          </div>
          <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <div class="col-md-12">
              <textarea rows="5" cols="5" name="keterangan" class="form-control" placeholder="Masukkan keterangan"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn me-2 btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Tambah Kas</button>
        </div>
      </form>
    </div>
  </div>
</div>
