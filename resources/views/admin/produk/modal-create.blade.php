<div class="modal fade" id="create-modal">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="page-wrapper-new p-0">
        <div class="content">
          <div class="modal-header">
            <div class="page-title">
              <h4>Tambah Produk</h4>
            </div>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="col-sm-6 col-12">
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
                </div>
                <div class="col-sm-6 col-12 row mb-3">
                  <div class="col-12">
                    <div class="mb-3">
                      <label for="nama">Nama Produk<span class="ms-1 text-danger">*</span></label>
                      <input type="text" class="form-control" name="nama" id="nama">
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="mb-3">
                      <label for="kategori">Kategori<span class="ms-1 text-danger">*</span></label>
                      <select class="select" required name="kategori" id="kategori">
                        <option value="" selected disabled>Pilih kategori</option>
                        @foreach ($categories as $item)
                          <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="mb-3">
                      <label for="satuan">Satuan<span class="ms-1 text-danger">*</span></label>
                      <select class="select" required name="satuan" id="satuan">
                        <option value="" selected disabled>Pilih satuan</option>
                        <option value="pcs">pcs</option>
                        <option value="gram">gram</option>
                        <option value="porsi">porsi</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-12">
                    <label for="harga">Harga</label>
                    <input type="text" class="form-control" id="harga" name="harga" placeholder="Rp. ">
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <div class="mb-3">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="stok_cek" name="stok_cek" value="on">
                        <label class="form-check-label" for="stok_cek">Berlakukan Stok</label>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="mb-3">
                      <label class="form-label" for="stok">Jumlah Stok<span
                          class="ms-1 text-danger">*</span></label>
                      <input type="number" class="form-control" name="stok" id="stok" disabled>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="mb-3 mb-3">
                      <label class="form-label" for="deskripsi">Deskripsi</label>
                      <textarea class="form-control" name="deskripsi" id="deskripsi"></textarea>
                      <p class="mt-1">Maximum 60 Characters</p>
                    </div>
                  </div>
                  <div class="col-12 text-end">
                    <button type="button" class="btn me-2 btn-secondary fs-13 fw-medium p-2 px-3 shadow-none"
                      data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary fs-13 fw-medium p-2 px-3">Submit</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const hargaInput = document.getElementById('harga');
    hargaInput.addEventListener('input', function(e) {
      let value = this.value.replace(/[^0-9]/g, '');
      if (value) {
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
      }
      this.value = value;
    });

    // Enable/disable stok input based on checkbox
    document.getElementById('stok_cek').addEventListener('change', function() {
      document.getElementById('stok').disabled = !this.checked;
    });
  });
</script>
