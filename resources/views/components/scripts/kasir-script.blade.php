<script>
    $(document).ready(function() {
        // Show only main buttons, hide pesanan-specific buttons
        $('#btn-proses, #btn-tolak, #btn-tunggu').addClass('d-none').hide();
        $('#btn-simpan, #btn-selesai').removeClass('d-none').show();

        $.ajax({
            type: "GET",
            url: "{{ url('kasir/get-data-kategori') }}",
            dataType: "html",
            success: function(data) {
                $("#tmp-data-kategori").html(data);
            },
            error: function() {
                $("#tmp-data-kategori").html(`<li class="text-danger">Gagal memuat kategori</li>`);
            }
        });

        loadProdukByKategori('all');
        loadKeranjang(); // Load cart without meja parameter
        subTotals(); // Load subtotals

        $(document).on("click", ".kategori-item", function(e) {
            e.preventDefault();
            var id_kategori = $(this).data("id");

            $(".kategori-item").removeClass("active");
            $(this).addClass("active");

            loadProdukByKategori(id_kategori);
        });

        function loadProdukByKategori(id_kategori, meja = '', status = '', query = '') {
            $("#tmp-data-produk").css("opacity", 0.4);

            $.ajax({
                type: "GET",
                url: "{{ url('kasir/get-data-produk') }}/" + id_kategori,
                data: {
                    search: query,
                    meja: meja,
                    status: status
                },
                dataType: 'html',
                success: function(data) {
                    $("#tmp-data-produk").html(data).css("opacity", 1);
                },
                error: function() {
                    $("#tmp-data-produk").html(`
                        <div class="alert alert-danger text-center mt-3" role="alert">
                            Gagal memuat data produk.
                        </div>
                    `).css("opacity", 1);
                }
            });
        }

        $("#search-product").on("input", function() {
            var searchQuery = $(this).val();
            var activeCategory = $(".kategori-item.active").data("id") || 'all';
            loadProdukByKategori(activeCategory, '', '', searchQuery);
        });

        $(document).on("click", ".tambah-item", function(e) {
            e.preventDefault();

            var button = $(this);
            var idProduk = button.data("id");
            var hargaProduk = button.data("harga");

            button.prop("disabled", true).text("Menambahkan...");

            $.ajax({
                type: "POST",
                url: "{{ url('kasir/post-transaksi-detail') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id_produk: idProduk,
                    sub_total: hargaProduk,
                    meja: '' // No meja required
                },
                success: function() {
                    button.prop("disabled", false).text("Tambah");

                    var toastHTML = `
                            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header">
                                <strong class="me-auto">Al-Kinza</strong>
                                <small>{{ date('d-m-Y H:i:s') }}</small>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                    Data Berhasil Ditambahkan
                                </div>
                            </div>
                        `;
                    $("#toastContainer").append(toastHTML);
                    var toast = new bootstrap.Toast($("#toastContainer .toast").last()[0]);
                    toast.show();

                    var activeCategory = $(".kategori-item.active").data("id") || 'all';
                    var searchQuery = $("#search-product").val();
                    loadProdukByKategori(activeCategory, '', '', searchQuery);
                    loadKeranjang();
                    subTotals();
                },
                error: function(err) {
                    button.prop("disabled", false).text("Tambah");
                    alert("Gagal menambahkan produk." + err.responseText);
                }
            });
        });

        function loadKeranjang(transaksi = '') {
            $("#tmp-data-keranjang").css("opacity", 0.4);
            $.ajax({
                type: "GET",
                url: "{{ url('kasir/get-data-keranjang') }}",
                dataType: "json",
                data: {
                    meja: '', // No meja
                    transaksi: transaksi
                },
                success: function(data) {
                    $("#tmp-data-keranjang").html(data.html).css("opacity", 1);
                    const transaksi = data.transaksi;
                    if (transaksi) {
                        $('#namaCust').val(transaksi.nama_pelanggan || '');
                        $('#kode-transaksi').text(transaksi.kode_transaksi || '-');
                        $('#btn-selesai').data('transaksi', transaksi.id);
                        subTotals(transaksi.id);
                        let bayar = transaksi.bayar ? transaksi.bayar.toString().replace(/\.00$/,
                            '') : '';
                        $('#input-bayar').val(bayar);
                    } else {
                        $('#kode-transaksi').text('-');
                    }

                    // Always show simpan and selesai buttons, hide others
                    $('#btn-proses, #btn-tolak, #btn-tunggu').addClass('d-none').hide();
                    $('#btn-simpan, #btn-selesai').removeClass('d-none').show();
                }
            });
        }


        function updateQty(id_detail, qty, harga, kuan = null) {
            const hargaEl = $('#tmp-harga-' + id_detail);
            const qtyEl = $('#qty-' + id_detail);

            hargaEl.addClass('fade-transition').css('opacity', 0.5);
            qtyEl.addClass('fade-transition').css('opacity', 0.5);

            $.ajax({
                url: "{{ url('/kasir/update-transaksi-qty') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    id_detail: id_detail,
                    qty: qty,
                    harga: harga,
                    kuan: kuan,
                    meja: '' // No meja
                },
                success: function(res) {
                    if (res.sub_total) {
                        if (res.qty == 0) {
                            loadKeranjang();
                            loadProdukByKategori('all', '', '');
                        } else if (res.qty >= 1) {
                            loadKeranjang();
                        } else {
                            qtyEl.val(res.qty);
                        }
                        subTotals();
                    } else {
                        loadKeranjang();
                        loadProdukByKategori('all', '', '');
                    }
                    hargaEl.css('opacity', 1);
                    qtyEl.css('opacity', 1);
                },
                error: function(xhr) {
                    alert('Gagal update qty.' + xhr.responseText);
                    hargaEl.css('opacity', 1);
                    qtyEl.css('opacity', 1);
                }
            });
        }

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(angka || 0);
        }

        function deleteItem(id) {
            $.ajax({
                url: "{{ url('/kasir/delete-item') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                success: function(res) {
                    if (res.success) {
                        loadKeranjang();
                        subTotals();
                        loadProdukByKategori('all');
                        alert('Item berhasil dihapus.');
                    } else {
                        alert('Gagal menghapus item.');
                    }
                },
                error: function(xhr) {
                    alert('Gagal menghapus item.' + xhr.responseText);
                }
            });
        }

        $(document).off('click', '#item-delete');
        $(document).on('click', '#item-delete', function(e) {
            e.preventDefault();
            if (!confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                return;
            }
            const id = $(this).data('id');
            deleteItem(id);

        });

        $(document).off('click', '.plus-qty');
        $(document).off('click', '.minus-qty');
        $(document).off('input', '.input-qty');

        let ignoreInputEvent = false;

        $(document).on('click', '.plus-qty', function() {
            const qtyInput = $(this).siblings('input.input-qty');
            const id = qtyInput.data('id');
            const harga = parseInt(qtyInput.data('harga')) || 0;
            ignoreInputEvent = true;
            updateQty(id, 'plus', harga);
            setTimeout(() => ignoreInputEvent = false, 500);
        });

        $(document).on('click', '.minus-qty', function() {
            const qtyInput = $(this).siblings('input.input-qty');
            let qty = parseInt(qtyInput.val()) || 1;
            const id = qtyInput.data('id');
            const harga = parseInt(qtyInput.data('harga')) || 0;

            if (qty >= 1) {
                ignoreInputEvent = true;
                updateQty(id, 'minus', harga);
                setTimeout(() => ignoreInputEvent = false, 500);
            }
        });

        let typingTimer;
        $(document).on('input', '.input-qty', function() {
            if (ignoreInputEvent) return;

            clearTimeout(typingTimer);

            const input = $(this);
            typingTimer = setTimeout(function() {
                let qty = parseInt(input.val()) || '';
                const id = input.data('id');
                const harga = parseInt(input.data('harga')) || 0;

                input.val(qty);
                updateQty(id, 'input', harga, qty);
            }, 400);
        });


        let totalBelanja = 0;

        function subTotals(transaksi = '') {
            $("#subtotals, #total, #counter-item").addClass('fade-transition').css('opacity', 0.5);
            $.ajax({
                type: "GET",
                url: "{{ url('kasir/get-data-subtotal') }}",
                dataType: 'json',
                data: {
                    meja: '', // No meja
                    transaksi: transaksi
                },
                success: function(data) {
                    // Ambil total belanja dari server (hilangkan Rp dan titik)
                    totalBelanja = parseInt(data.total.replace(/\D/g, '')) || 0;

                    $("#subtotals").html(data.total).css('opacity', 1);
                    $("#total").html(data.total).css('opacity', 1);
                    $("#counter-item").html(data.count).css('opacity', 1);
                    $('#totals').attr('data-total', totalBelanja);
                    
                    // Update payment if checkbox is checked
                    if ($('#checkbox-bayar-pas').is(':checked')) {
                        $('#input-bayar').val(formatRupiah(totalBelanja));
                    }
                    
                    hitungKembali();
                }
            });
        }

        $(document).on('click', '.btn-bayar', function() {
            let nominal = parseInt($(this).data('nominal'));
            let current = parseInt($('#input-bayar').val().replace(/\D/g, '')) || 0;
            let total = current + nominal;

            $('#input-bayar').val(formatRupiah(total));
            $('#clear-bayar').show();
            hitungKembali();
        });


        $('#input-bayar').on('input', function() {
            let val = $(this).val();
            if (val.length > 0) {
                $('#clear-bayar').show();
            } else {
                $('#clear-bayar').hide();
            }

            let raw = val.replace(/\D/g, '');
            $(this).val(formatRupiah(raw));
            hitungKembali();
        });

        $('#clear-bayar').on('click', function() {
            $('#input-bayar').val('');
            $(this).hide();
            $('#kembali').html('Rp 0');
        });

        // Handle "Bayar Pas / Non Tunai" checkbox
        $('#checkbox-bayar-pas').on('change', function() {
            if ($(this).is(':checked')) {
                // Checkbox is checked - disable input and set to total
                $('#input-bayar').prop('disabled', true);
                $('#input-bayar').val(formatRupiah(totalBelanja));
                $('#clear-bayar').hide();
                $('#btn-bayar-container .btn-bayar').prop('disabled', true).addClass('disabled');
                hitungKembali();
            } else {
                // Checkbox is unchecked - enable input
                $('#input-bayar').prop('disabled', false);
                $('#input-bayar').val('');
                $('#btn-bayar-container .btn-bayar').prop('disabled', false).removeClass('disabled');
                $('#kembali').html('Rp 0');
            }
        });


        function hitungKembali() {
            let bayar = parseInt($('#input-bayar').val().replace(/\D/g, '')) || 0;
            let kembali = bayar - totalBelanja;

            if (bayar === 0) {
                $('#kembali').html('Rp 0');
            } else if (kembali < 0) {
                $('#kembali').html('<span class="text-danger">Pembayaran kurang!</span>');
            } else {
                $('#kembali').html('Rp ' + formatRupiah(kembali));
            }
        }

        function formatRupiah(angka) {
            if (!angka) return '';
            return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        $('#form-transaksi').on('submit', function(e) {
            e.preventDefault();
            if (!confirm('Apakah Anda yakin ingin menyelesaikan transaksi?')) {
                return;
            }
            const transaksi = $("#btn-selesai").data('transaksi');
            if (transaksi) {
                simpan('selesai', transaksi);
            } else {
                simpan('selesai');
            }
        });

        $('#btn-simpan').on('click', function(e) {
            e.preventDefault();
            if (!confirm('Apakah Anda yakin ingin menyimpan transaksi sebagai pending?')) {
                return;
            }
            simpan('pending');
        });

        function simpan(status, transaksi = '') {
            let totalTagihan, bayar, kembali;
            const nama = $('#namaCust').val();

            if (status == 'selesai') {
                totalTagihan = parseInt($('#totals').data('total')) || 0;
                bayar = parseInt(($('#input-bayar').val() || '').replace(/\D/g, '')) || 0;
                kembali = bayar - totalTagihan;
                if (bayar < totalTagihan) {
                    alert('Nominal pembayaran kurang!');
                    return;
                }
            } else {
                totalTagihan = 0;
                bayar = 0;
                kembali = 0;
            }

            $.ajax({
                url: "{{ url('/kasir/post-data-transaksi') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    total_tagihan: totalTagihan,
                    bayar: bayar,
                    kembali: kembali,
                    meja: '', // No meja
                    nama: nama,
                    status: status,
                    transaksi: transaksi
                },
                success: function(response) {
                    if (status == 'pending') {
                        alert('Transaksi berhasil disimpan sebagai pending!');
                        window.location.reload();
                    } else {
                        alert('Transaksi berhasil diselesaikan!');
                        console.log(response);
                        $('#input-bayar').val('');
                        $('#kembali').html('Rp 0');
                        const modal = new bootstrap.Modal($('#print-receipt')[0]);
                        console.log(response.transaksi);
                        modal.show();
                        loadPrint(response.transaksi.id);
                    }
                },
                error: function(xhr) {
                    alert('Gagal menyimpan transaksi: ' + xhr.responseText);
                }
            });
        }

        function loadPrint(transaksi) {
            $.ajax({
                url: "{{ url('/kasir/get-data-print') }}/" + transaksi,
                method: "GET",
                dataType: "html",
                success: function(data) {
                    $('#tmp-print').html(data);
                    // Store transaction ID for PDF download
                    $('#btnDownloadPdf').data('transaksi', transaksi);
                },
                error: function(xhr) {
                    alert(xhr.responseText);
                    $('#tmp-print').html(
                        '<div class="alert alert-danger">Gagal Mendapatkan Data</div>');
                }
            });
        }

        // Handle PDF download button
        $(document).on('click', '#btnDownloadPdf', function() {
            const transaksi = $(this).data('transaksi');
            if (transaksi) {
                window.open("{{ url('/kasir/download-pdf') }}/" + transaksi, '_blank');
            }
        });

        // Button to open pending transactions modal
        $('#btn-pending-orders').on('click', function() {
            loadPendingTransactions();
            const modal = new bootstrap.Modal(document.getElementById('modalPending'));
            modal.show();
        });

        function loadPendingTransactions() {
            $.ajax({
                type: "GET",
                url: "{{ url('/kasir/get-data-pesanan') }}",
                dataType: "html",
                success: function(response) {
                    $("#tmp-modal-pending").html(response);
                },
                error: function() {
                    $("#tmp-modal-pending").html(
                        `<div class="alert alert-danger" role="alert">Gagal Memuat Transaksi Pending</div>`
                        );
                }
            });
        }

        // Handle pending transaction selection
        $(document).on('click', '.pesanan-btn', function() {
            const id = $(this).data('id');
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalPending'));
            modal.hide();

            // Load the pending transaction into cart
            loadKeranjang(id);
            loadProdukByKategori('all', '', '');
            subTotals(id);
        });

    });
</script>
