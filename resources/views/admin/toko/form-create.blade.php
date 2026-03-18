<!-- Modal Create -->
<div class="modal fade" id="tambahToko">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="page-title">
          <h4>Form Tambah Toko</h4>
        </div>
        <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <form action="{{ route('toko.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <div class="col-md-12 d-flex gap-3 justify-content-center">
              <!-- First Image Uploader -->
              <div class="cardd me-3">
                <div class="imagesss">
                  <img id="imgCreatePreview" src="{{ asset('assets/uploadImg/upload.jpg') }}" width="200"
                    alt="Preview">
                  <p class="imgName" id="imgCreateName"></p>
                </div>
                <label class="labell" for="inputGambarCreate">
                  <span class="tmbl">Pilih Logo<span class="text-danger">*</span></span>
                </label>
                <input name="gambar" class="inputt" type="file" id="inputGambarCreate" accept="image/*">
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Nama Toko<span class="text-danger ms-1">*</span></label>
            <input type="text" name="nama_toko" class="form-control" required placeholder="Masukkan nama toko">
          </div>
          <div class="mb-3">
            <label class="form-label">Alamat</label>
            <input type="text" name="alamat_toko" class="form-control" placeholder="Masukkan alamat toko">
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <div class="col-md-12">
              <textarea rows="5" cols="5" name="deskripsi" class="form-control" placeholder="Masukkan deskripsi"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn me-2 btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Tambah Toko</button>
        </div>
      </form>
    </div>
  </div>
</div>
