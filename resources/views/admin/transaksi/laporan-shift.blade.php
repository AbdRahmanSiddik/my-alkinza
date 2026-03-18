<x-admin-panel>
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Laporan Shift</h4>
                <h6>Data Transaksi Per Shift Per Hari</h6>
            </div>
        </div>
        <ul class="table-top-head">
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf">
                    <img src="{{ asset('assets/img/icons/pdf.svg') }}" alt="img">
                </a>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel">
                    <img src="{{ asset('assets/img/icons/excel.svg') }}" alt="img">
                </a>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header">
                    <i class="ti ti-chevron-up"></i>
                </a>
            </li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
            <div class="search-set">
                <div class="search-input">
                    <span class="btn-searchset">
                        <i class="ti ti-search fs-14 feather-search"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table datatable">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Hari, Tanggal</th>
                            @foreach ($kasir as $item)
                                <th>Kasir {{ $item->name }}</th>
                            @endforeach
                            <th>Total</th>
                            <th>Tunai</th>
                            <th>Non-Tunai</th>
                            <th class="no-sort"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laporan as $tanggal => $data)

                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
                                </td>

                                {{-- Kolom Kasir --}}
                                @php $grandTotal = 0; @endphp
                                @foreach ($kasir as $kasirItem)
                                    @php
                                        $detailKasir = $data['kasir'][$kasirItem->id] ?? null;
                                        $totalKasir = $detailKasir['total'] ?? 0;
                                        $grandTotal += $totalKasir;
                                    @endphp
                                    <td>Rp {{ number_format($totalKasir, 0, ',', '.') }}</td>
                                @endforeach

                                {{-- Total --}}
                                <td>
                                    <strong>Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong>
                                </td>

                                {{-- Tunai --}}
                                <td>
                                    Rp {{ number_format($data['tunai'], 0, ',', '.') }}
                                </td>

                                {{-- Non Tunai --}}
                                <td>
                                    Rp {{ number_format($data['non_tunai'], 0, ',', '.') }}
                                </td>

                                <td>
                                    <a role="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#detailModal{{ $loop->iteration }}">Detail</a>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 5 + $kasir->count() }}" class="text-center">
                                    Tidak ada transaksi diselesaikan.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>

                @foreach ($laporan as $tanggal => $data)
                    {{-- <div class="modal fade" id="detailModal{{ $loop->iteration }}" tabindex="-1">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        Detail Shift
                                        {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Kasir</th>
                                                <th>Tunai</th>
                                                <th>Non Tunai</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($kasir as $kasirItem)
                                                @php
                                                    $detail = $data['kasir'][$kasirItem->id] ?? null;
                                                @endphp
                                                <tr>
                                                    <td>{{ $kasirItem->name }}</td>
                                                    <td>Rp {{ number_format($detail['tunai'] ?? 0, 0, ',', '.') }}</td>
                                                    <td>Rp {{ number_format($detail['non_tunai'] ?? 0, 0, ',', '.') }}
                                                    </td>
                                                    <td>Rp {{ number_format($detail['total'] ?? 0, 0, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div> --}}

                    {{-- MODAL --}}
                    <div class="modal fade" id="detailModal{{ $loop->iteration }}" tabindex="-1">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        Detail Shift
                                        {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">

                                    {{-- PRINT AREA --}}
                                    <div class="print-area" id="print-area-{{ $loop->iteration }}">

                                        <div class="center bold">
                                            LAPORAN SHIFT<br>
                                            {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
                                        </div>

                                        <div class="line"></div>

                                        @php
                                            $grandTunai = 0;
                                            $grandNon = 0;
                                            $grandTotal = 0;
                                        @endphp

                                        @foreach ($kasir as $kasirItem)
                                            @php
                                                $detail = $data['kasir'][$kasirItem->id] ?? null;

                                                $tunai = $detail['tunai'] ?? 0;
                                                $non = $detail['non_tunai'] ?? 0;
                                                $total = $detail['total'] ?? 0;

                                                $grandTunai += $tunai;
                                                $grandNon += $non;
                                                $grandTotal += $total;
                                            @endphp

                                            <div class="bold">{{ $kasirItem->name }}</div>

                                            <div>
                                                Tunai : Rp {{ number_format($tunai, 0, ',', '.') }}
                                            </div>
                                            <div>
                                                Non : Rp {{ number_format($non, 0, ',', '.') }}
                                            </div>
                                            <div class="bold">
                                                Total : Rp {{ number_format($total, 0, ',', '.') }}
                                            </div>

                                            <div class="line"></div>
                                        @endforeach


                                        <div class="bold">TOTAL KESELURUHAN</div>

                                        <div>Total Tunai : Rp {{ number_format($grandTunai, 0, ',', '.') }}</div>
                                        <div>Total Non Tunai : Rp {{ number_format($grandNon, 0, ',', '.') }}</div>
                                        <div class="bold">GRAND TOTAL : Rp {{ number_format($grandTotal, 0, ',', '.') }}
                                        </div>

                                        <div class="line"></div>

                                        <div class="center">
                                            --- Terima Kasih ---
                                        </div>

                                    </div>


                                    <div class="mt-3 text-end">
                                        <button class="btn btn-dark btn-sm"
                                            onclick="printShift('{{ $loop->iteration }}')">
                                            Print Thermal
                                        </button>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </div>

    {{-- SCRIPT PRINT --}}
    <script>
        function printShift(id) {

            let area = document.getElementById('print-area-' + id);

            if (!area) {
                alert('Print area tidak ditemukan!');
                return;
            }

            let content = area.innerHTML;

            let printWindow = window.open('', '', 'width=400,height=600');

            printWindow.document.write(`
        <html>
        <head>
            <title>Print Shift</title>
            <style>
                @page { size: 52mm auto; margin: 0; }
                body {
                    width: 52mm;
                    margin: 0;
                    padding: 2mm;
                    font-family: monospace;
                    font-size: 10px;
                }
                table { width: 100%; border-collapse: collapse; }
                th, td { padding: 2px 0; font-size: 10px; }
                .right { text-align: right; }
                .center { text-align: center; }
                .bold { font-weight: bold; }
                .line { border-top: 1px dashed #000; margin: 4px 0; }
            </style>
        </head>
        <body onload="window.print(); window.close();">
            ${content}
        </body>
        </html>
    `);

            printWindow.document.close();
        }
    </script>

</x-admin-panel>
