<x-landing>

  <section class="menu_page mt_100 xs_mt_70 mb_100 xs_mb_70">
    <div class="container" style="margin-top: 10rem">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode Transaksi</th>
                  <th>Tanggal</th>
                  <th>Estimasi</th>
                  <th>Status</th>
                  <th>Total</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse($pesanan as $index => $order)
                  <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $order->kode_transaksi }}</td>
                    <td>
                      {{ $order->created_at->format('d M Y - H:i') }}
                    </td>
                    <td>
                      {{ $order->created_at->addMinutes(30)->format('d M Y - H:i') }}
                    </td>
                    <td>
                      @php
                        $status = strtolower($order->status);
                        $badgeClass = match ($status) {
                            'pending' => 'badge bg-warning text-dark',
                            'proses' => 'badge bg-info text-dark',
                            'selesai' => 'badge bg-success',
                            'batal' => 'badge bg-danger',
                            default => 'badge bg-secondary',
                        };
                      @endphp
                      <span class="{{ $badgeClass }}">{{ ucfirst($order->status) }}</span>
                    </td>
                    <td>@rupiah($order->total_harga)</td>
                    <td>
                      <a role="button" data-bs-toggle="modal" data-bs-target="#detailModal{{ $order->id }}"
                        class="btn btn-primary btn-sm">Detail</a>
                      <a role="button" data-bs-toggle="modal" data-bs-target="#buktiBayarModal{{ $order->id }}"
                        class="btn btn-success btn-sm">Cek Bukti</a>
                    </td>
                  </tr>

                  <div class="modal fade" id="buktiBayarModal{{ $order->id }}" tabindex="-1"
                    data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="modalTitleId">
                            Bukti Pembayaran: {{ $order->kode_transaksi }}
                          </h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <img src="{{ $order->url_foto }}" alt="">
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="modal fade" id="detailModal{{ $order->id }}" tabindex="-1"
                    data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="modalTitleId">
                            Bukti Pembayaran: {{ $order->kode_transaksi }}
                          </h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row fw-bold border-bottom pb-2 mb-2">
                                <div class="col-5">Produk</div>
                                <div class="col-2">Qty</div>
                                <div class="col-2">Satuan</div>
                                <div class="col-3">Subtotal</div>
                            </div>
                            @foreach($order->produkPivot as $detail)
                                <div class="row align-items-center py-2 border-bottom">
                                    <div class="col-5">{{ $detail->produk->name ?? '-' }}</div>
                                    <div class="col-2">{{ $detail->kuantitas }}</div>
                                    <div class="col-2">@rupiah($detail->produk->harga)</div>
                                    <div class="col-3">@rupiah($detail->subtotal)</div>
                                </div>
                            @endforeach
                        </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>



                @empty
                  <tr>
                    <td colspan="6" class="text-center">
                      Tidak ada transaksi ditemukan.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>

</x-landing>
