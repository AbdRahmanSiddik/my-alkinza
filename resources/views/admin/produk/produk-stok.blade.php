<x-admin-panel>
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Manajemen Stok</h4>
                <h6>Manage Stok Produk Anda</h6>
            </div>
        </div>
        <ul class="table-top-head">
            <li>
                <a role="button" id="downloadPdf" data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf"><img
                        src="{{ asset('assets/img/icons/pdf.svg') }}" alt="img"></a>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel"><img
                        src="{{ asset('assets/img/icons/excel.svg') }}" alt="img"></a>
            </li>
            <li>
                <a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i
                        class="ti ti-refresh"></i></a>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                        class="ti ti-chevron-up"></i></a>
            </li>
        </ul>
    </div>

    <!-- /product list -->
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
            <div class="search-set">
                <div class="search-input">
                    <span class="btn-searchset"><i class="ti ti-search fs-14 feather-search"></i></span>
                </div>
            </div>
            <div class="d-flex table-dropdown my-xl-auto right-content align-items-center flex-wrap row-gap-3">
                <div class="dropdown me-2">
                    <a href="javascript:void(0);"
                        class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center"
                        data-bs-toggle="dropdown">
                        Kategori
                    </a>
                    <ul class="dropdown-menu  dropdown-menu-end p-3">
                        @foreach ($categories as $cat)
                            <li>
                                <a href="?cat={{ $cat->token_kategori }}"
                                    class="dropdown-item rounded-1">{{ $cat->name }}</a>
                            </li>
                        @endforeach

                    </ul>
                </div>
                <a href="{{ route('produk.stok') }}" class="btn btn-danger">Clear</a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive" id="area-laporan">
                <table class="table datatable" id="table-laporan">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Satuan</th>
                            <th>Stok</th>
                            <th>Total Terjual</th>
                            <th>Jumlah Gramasi</th>
                            <th class="no-sort"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                            <img alt="product"
                                                data-cfsrc="{{ asset($item->foto ?? 'assets/img/download-img.png') }}"
                                                style="display:none;visibility:hidden;"><noscript><img
                                                    src="{{ asset($item->foto ?? 'assets/img/download-img.png') }}"
                                                    alt="product"></noscript>
                                        </a>
                                        <a href="javascript:void(0);">{{ $item->name }} </a>
                                    </div>
                                </td>
                                <td>{{ $item->kategori->name }}</td>
                                <td>@rupiah($item->harga)</td>
                                <td>{{ $item->satuan }}</td>
                                <td>
                                    @if ($item->status_stok == 'off')
                                        <span class="badge bg-secondary">Off</span>
                                    @else
                                        {{ $item->stok }}
                                    @endif
                                </td>
                                @if ($item->satuan == 'gram')
                                    <td>{{ $item->total_gram }}</td>
                                @else
                                    <td>{{ $item->total_terjual }}</td>
                                @endif
                                <td>
                                    @if ($item->satuan == 'gram')
                                        {{ $item->total_terjual }} gram
                                    @else
                                        item satuan
                                    @endif
                                </td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">

                                        <a class="me-2 p-2" role="button" data-bs-toggle="modal"
                                            data-bs-target="#edit-modal{{ $item->token_product }}">
                                            <i data-feather="edit" class="feather-edit"></i>
                                        </a>
                                        <a class="me-2 p-2" role="button" data-bs-toggle="modal"
                                            data-bs-target="#harga-modal{{ $item->token_product }}">
                                            <i class="ti ti-currency-dollar"></i>
                                        </a>

                                    </div>
                                </td>
                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="edit-modal{{ $item->token_product }}" tabindex="-1"
                                role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTitleId">
                                                Manage Stok: {{ $item->name }}
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('produk-stok.update', $item->token_product) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')

                                                {{-- Checkbox Berlakukan Stok --}}
                                                <div class="mb-3 form-group">
                                                    <label class="form-check-label"
                                                        for="stok{{ $item->token_product }}">
                                                        <input type="checkbox" name="stok_status"
                                                            id="stok{{ $item->token_product }}"
                                                            class="form-check-input toggle-stok"
                                                            {{ $item->status_stok == 'off' ? '' : 'checked' }}>
                                                        <strong>Berlakukan Stok?</strong>
                                                    </label>
                                                </div>

                                                {{-- Kontrol Stok --}}
                                                <div class="mb-3 form-group stok-control"
                                                    id="stok-control-{{ $item->token_product }}"
                                                    style="{{ $item->status_stok == 'off' ? 'display:none;' : '' }}">
                                                    <label class="form-label">Jumlah Stok</label>
                                                    <div class="input-group">
                                                        <button type="button"
                                                            class="btn btn-outline-secondary minus-btn">−</button>
                                                        <input type="number"
                                                            class="form-control text-center stok-input"
                                                            name="stok_value"
                                                            value="{{ $item->status_stok == 'off' ? '' : $item->stok }}"
                                                            placeholder="{{ $item->status_stok == 'off' ? 'off' : '' }}"
                                                            {{ $item->status_stok == 'off' ? 'disabled' : '' }}>
                                                        <button type="button"
                                                            class="btn btn-outline-secondary plus-btn">+</button>
                                                    </div>
                                                </div>

                                                <div class="text-end d-flex justify-content-end gap-2">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="harga-modal{{ $item->token_product }}" tabindex="-1"
                                role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTitleId">
                                                Manage Stok: {{ $item->name }}
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form
                                                action="{{ route('produk-stok.update-harga', $item->token_product) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')

                                                <div class="mb-3">
                                                    <label class="form-label">Harga Sekarang</label>
                                                    <div class="form-control-plaintext fw-bold mb-2">
                                                        @rupiah($item->harga)
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="harga{{ $item->token_product }}"
                                                        class="form-label">Ubah Harga</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">Rp.</span>
                                                        <input type="number" class="form-control"
                                                            id="harga{{ $item->token_product }}" name="harga"
                                                            value="{{ $item->harga }}" min="0" required>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="satuan{{ $item->token_product }}"
                                                        class="form-label">Satuan</label>
                                                    <select class="form-select" id="satuan{{ $item->token_product }}"
                                                        name="satuan" required>
                                                        <option value="pcs"
                                                            {{ $item->satuan == 'pcs' ? 'selected' : '' }}>pcs</option>
                                                        <option value="gram"
                                                            {{ $item->satuan == 'gram' ? 'selected' : '' }}>gram
                                                        </option>
                                                        <option value="porsi"
                                                            {{ $item->satuan == 'porsi' ? 'selected' : '' }}>porsi
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="text-end d-flex justify-content-end gap-2">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        if (!window.stokHandlerLoaded) {

            window.stokHandlerLoaded = true;

            document.addEventListener('click', function(e) {

                if (e.target.classList.contains('minus-btn')) {
                    const group = e.target.closest('.stok-control');
                    const input = group.querySelector('.stok-input');

                    let val = parseInt(input.value) || 0;
                    if (val > 0) input.value = val - 1;
                }

                if (e.target.classList.contains('plus-btn')) {
                    const group = e.target.closest('.stok-control');
                    const input = group.querySelector('.stok-input');

                    let val = parseInt(input.value) || 0;
                    input.value = val + 1;
                }

            });

            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('toggle-stok')) {

                    const id = e.target.id.replace('stok', '');
                    const control = document.getElementById('stok-control-' + id);
                    const input = control.querySelector('.stok-input');

                    if (e.target.checked) {
                        control.style.display = '';
                        input.disabled = false;
                        if (!input.value) input.value = 0;
                    } else {
                        control.style.display = 'none';
                        input.value = '';
                        input.disabled = true;
                    }
                }
            });

        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const btn = document.getElementById('downloadPdf');
            if (!btn) return;

            btn.addEventListener('click', function() {

                const {
                    jsPDF
                } = window.jspdf;
                const pdf = new jsPDF('l', 'mm', 'a4');

                // Ambil instance datatable
                const table = $('.datatable').DataTable();

                // Ambil SEMUA data (bukan cuma page sekarang)
                const allData = table.rows().data().toArray();

                // Ambil header kecuali kolom terakhir (Aksi)
                let headers = [];
                $('#table-laporan thead th').each(function(index) {
                    if (index !== $('#table-laporan thead th').length - 1) {
                        headers.push($(this).text().trim());
                    }
                });

                // Ambil isi row kecuali kolom aksi
                let body = [];

                allData.forEach(function(row) {

                    let rowData = [];

                    // row itu bentuknya array HTML string
                    for (let i = 0; i < row.length - 1; i++) {

                        let tempDiv = document.createElement("div");
                        tempDiv.innerHTML = row[i];

                        rowData.push(tempDiv.textContent.trim());
                    }

                    body.push(rowData);
                });

                pdf.text("Laporan Manajemen Stok", 14, 15);

                pdf.autoTable({
                    startY: 20,
                    head: [headers],
                    body: body,
                    styles: {
                        fontSize: 8
                    },
                    headStyles: {
                        fillColor: [220, 53, 69] // merah bootstrap
                    }
                });

                pdf.save("manajemen-stok.pdf");
            });

        });
    </script>

    <!-- /product list -->
</x-admin-panel>
