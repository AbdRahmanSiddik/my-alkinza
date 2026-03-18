@foreach ($products as $item)
  <div class="modal fade" id="edit-modal{{ $item->token_product }}">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="page-wrapper-new p-0">
          <div class="content">
            <div class="modal-header">
              <div class="page-title">
                <h4>Edit Produk <strong>{{ $item->name }}</strong></h4>
              </div>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{ route('produk.update', $item->token_product) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                  <div class="col-sm-6 col-12">
                    <div class="mb-3">
                      <div class="col-md-12 d-flex justify-content-center">
                        <div class="cardd">
                          <div class="imagesss">
                            <img id="imgEditPreview{{ $item->token_product }}"
                              src="{{ asset($item->foto ?? 'assets/uploadImg/upload.jpg') }}" width="400"
                              alt="Preview">
                            <p class="imgName" id="imgEditName{{ $item->token_product }}"></p>
                          </div>
                          <label class="labell" for="inputGambarEdit{{ $item->token_product }}">
                            <span class="tmbl">Pilih Gambar<span class="text-danger">*</span></span>
                          </label>
                          <input name="gambar" class="inputt" type="file"
                            id="inputGambarEdit{{ $item->token_product }}" accept="image/*">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-12 row mb-3">
                    <div class="col-12">
                      <div class="mb-3">
                        <label for="nama">Nama Produk<span class="ms-1 text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama" id="nama{{ $item->token_product }}"
                          value="{{ $item->name }}">
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="mb-3">
                        <label for="kategori">Kategori<span class="ms-1 text-danger">*</span></label>
                        <select class="select" required name="kategori" id="kategori{{ $item->token_product }}">
                          <option value="" selected disabled>Pilih kategori</option>
                          @foreach ($categories as $get)
                            <option value="{{ $get->id }}"
                              {{ $item->kategori_id == $get->id ? 'selected' : '' }}>
                              {{ $get->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="mb-3">
                        <label for="satuan">Satuan<span class="ms-1 text-danger">*</span></label>
                        <select class="select" required name="satuan" id="satuan{{ $item->token_product }}">
                          <option value="" selected disabled>Pilih satuan</option>
                          <option value="pcs" {{ $item->satuan == 'pcs' ? 'selected' : '' }}>pcs</option>
                          <option value="gram" {{ $item->satuan == 'gram' ? 'selected' : '' }}>gram</option>
                          <option value="porsi" {{ $item->satuan == 'porsi' ? 'selected' : '' }}>porsi</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-12">
                      <label for="harga">Harga</label>
                      <input type="text" class="form-control" id="harga{{ $item->token_product }}" name="harga"
                        placeholder="Rp. " value="{{ $item->harga }}">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <div class="mb-3">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="checkbox" id="stok_cek{{ $item->token_product }}"
                            name="stok_cek" value="on" {{ $item->status_cek == 'on' ? 'checked' : '' }}>
                          <label class="form-check-label" for="stok_cek{{ $item->token_product }}">Berlakukan
                            Stok</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="mb-3">
                        <label class="form-label" for="stok">Jumlah Stok<span
                            class="ms-1 text-danger">*</span></label>
                        <input type="number" class="form-control" name="stok" id="stok{{ $item->token_product }}"
                          {{ $item->status_cek == 'on' ? '' : 'disabled' }} value="{{ $item->stok }}">
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="mb-3 mb-3">
                        <label class="form-label" for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi">{!! $item->deskripsi !!}</textarea>
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
@endforeach

<script>
  document.addEventListener('DOMContentLoaded', function() {
    @foreach ($products as $item)
      // Harga input formatting
      const hargaInput{{ $item->token_product }} = document.getElementById('harga{{ $item->token_product }}');
      if (hargaInput{{ $item->token_product }}) {
        hargaInput{{ $item->token_product }}.addEventListener('input', function(e) {
          let value = this.value.replace(/[^0-9]/g, '');
          if (value) {
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
          }
          this.value = value;
        });
        // Format default value on load
        let defaultValue = hargaInput{{ $item->token_product }}.value.replace(/[^0-9]/g, '');
        if (defaultValue) {
          defaultValue = defaultValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
          hargaInput{{ $item->token_product }}.value = defaultValue;
        }
      }

      // Enable/disable stok input based on checkbox
      const stokCek{{ $item->token_product }} = document.getElementById('stok_cek{{ $item->token_product }}');
      const stokInput{{ $item->token_product }} = document.getElementById('stok{{ $item->token_product }}');
      if (stokCek{{ $item->token_product }} && stokInput{{ $item->token_product }}) {
        stokCek{{ $item->token_product }}.addEventListener('change', function() {
          stokInput{{ $item->token_product }}.disabled = !this.checked;
        });
      }
    @endforeach
  });
</script>
