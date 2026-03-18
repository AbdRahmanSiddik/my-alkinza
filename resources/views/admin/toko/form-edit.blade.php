@foreach ($tokos as $item)
  <!-- Modal Edit -->
  <div class="modal fade" id="editToko{{ $item->token_toko }}">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div class="page-title">
            <h4>Form Edit Toko</h4>
          </div>
          <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <form action="{{ route('toko.update', $item->token_toko) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="modal-body">
            <div class="mb-3">
              <div class="col-md-12 d-flex gap-3 justify-content-center">
                <div class="cardd">
                  <div class="imagesss">
                    <img id="imgEditPreview{{ $item->token_toko }}" src="{{ asset($item->logo ?? 'assets/uploadImg/upload.jpg') }}"
                      width="400" alt="Preview">
                    <p class="imgName" id="imgEditName{{ $item->token_toko }}"></p>
                  </div>
                  <label class="labell" for="inputGambarEdit{{ $item->token_toko }}">
                    <span class="tmbl">Pilih Gambar<span class="text-danger">*</span></span>
                  </label>
                  <input name="gambar" class="inputt" type="file" id="inputGambarEdit{{ $item->token_toko }}" accept="image/*">
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Nama Toko<span class="text-danger ms-1">*</span></label>
              <input type="text" class="form-control" value="{{ $item->name }}" name="nama_toko"
                placeholder="Masukkan nama toko" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Alamat</label>
              <input type="text" name="alamat_toko" value="{{ $item->addres }}" class="form-control"
                placeholder="Masukkan alamat toko">
            </div>
            <div class="mb-3">
              <label class="form-label">Deskripsi</label>
              <div class="col-md-12">
                <textarea rows="5" cols="5" name="deskripsi" class="form-control" placeholder="Masukkan deskripsi">{!! $item->deskripsi !!}</textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn me-2 btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-warning">Update Toko</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endforeach
