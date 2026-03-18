@foreach ($kategoris as $item)
  <!-- Modal Edit -->
  <div class="modal fade" id="editKategori{{ $item->token_kategori }}">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div class="page-title">
            <h4>Form Edit Kategori</h4>
          </div>
          <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <form action="{{ route('kategori.update', $item->token_kategori) }}" method="POST"
          enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="modal-body">
            <div class="mb-3">
              <div class="col-md-12 d-flex justify-content-center">
                <div class="cardd">
                  <div class="imagesss">
                    <img id="imgEditPreview{{ $item->token_kategori }}"
                      src="{{ asset($item->icon ?? 'assets/uploadImg/upload.jpg') }}" width="400" alt="Preview">
                    <p class="imgName" id="imgEditName{{ $item->token_kategori }}"></p>
                  </div>
                  <label class="labell" for="inputGambarEdit{{ $item->token_kategori }}">
                    <span class="tmbl">Pilih Gambar<span class="text-danger">*</span></span>
                  </label>
                  <input name="gambar" class="inputt" type="file" id="inputGambarEdit{{ $item->token_kategori }}"
                    accept="image/*">
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Nama Kategori<span class="text-danger ms-1">*</span></label>
              <input type="text" class="form-control" value="{{ $item->name }}" name="nama_kategori"
                placeholder="Masukkan nama kategori" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn me-2 btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-warning">Update Kategori</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endforeach
