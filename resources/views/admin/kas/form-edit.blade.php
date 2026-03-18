@foreach ($kas as $item)
  <div class="modal fade" id="editKas{{ $item->token_kas }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div class="page-title">
            <h4>Edit Data Kas</h4>
          </div>
          <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <form action="{{ route('kas.update', $item->token_kas) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Nama Kas<span class="text-danger ms-1">*</span></label>
              <input type="text" name="nama_kas" class="form-control" required value="{{ $item->nama }}"
                placeholder="Masukkan nama kas">
            </div>
            <div class="mb-3">
              <label class="form-label">Jenis Kas<span class="text-danger ms-1">*</span></label>
              <div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="jenis_kas"
                    id="radioPemasukan{{ $item->token_kas }}" value="pemasukan"
                    {{ $item->jenis === 'pemasukan' ? 'checked' : '' }}>
                  <label class="form-check-label" for="radioPemasukan{{ $item->token_kas }}">Pemasukan</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="jenis_kas"
                    id="radioPengeluaran{{ $item->token_kas }}" value="pengeluaran"
                    {{ $item->jenis === 'pengeluaran' ? 'checked' : '' }}>
                  <label class="form-check-label" for="radioPengeluaran{{ $item->token_kas }}">Pengeluaran</label>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Nominal Kas<span class="text-danger ms-1">*</span></label>
              <input type="number" name="nominal_kas" class="form-control" required placeholder="Masukkan nominal kas"
                min="0" value="{{ $item->jumlah }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            </div>
            <div class="mb-3">
              <label class="form-label">Keterangan</label>
              <textarea rows="5" cols="5" name="keterangan" class="form-control" placeholder="Masukkan keterangan">{{ $item->keterangan }}</textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endforeach
