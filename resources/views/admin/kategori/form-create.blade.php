<!-- Modal Create -->
<div class="modal fade" id="tambahKategori">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="page-title">
          <h4>Form Tambah Kategori</h4>
        </div>
        <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <form action="{{ route('kategori.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <div class="col-md-12 d-flex justify-content-center">
              <div class="cardd">
                <div class="imagesss">
                  <img id="imgCreatePreview" src="{{ asset('assets/uploadImg/upload.jpg') }}" width="400"
                    alt="Preview">
                  <p class="imgName" id="imgCreateName"></p>
                </div>
                <label class="labell" for="inputGambarCreate">
                  <span class="tmbl">Pilih Gambar<span class="text-danger">*</span></span>
                </label>
                <input name="gambar" class="inputt" type="file" id="inputGambarCreate" accept="image/*">
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Nama Kategori<span class="text-danger ms-1">*</span></label>
            <input type="text" name="nama_kategori" class="form-control" required
              placeholder="Masukkan nama kategori">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn me-2 btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Tambah Kategori</button>
        </div>
      </form>
    </div>
  </div>
</div>
