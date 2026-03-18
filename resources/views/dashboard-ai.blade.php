<x-admin-panel>
  {{-- Header & Filter --}}
  <div class="mb-4">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
      <div>
        <h1 class="mb-1">Dashboard Penjualan</h1>
        <p class="fw-medium">Selamat datang, <span class="text-primary fw-bold">{{ Session::get('toko.name') }}</span></p>
      </div>
    </div>

    {{-- Filter Section --}}
    <div class="card">
      <div class="card-body">
        <div class="row g-3 align-items-end">
          {{-- Filter Hari Ini --}}
          <div class="col-auto">
            <button type="button" class="btn btn-primary" id="btn-today">
              <i class="ti ti-calendar"></i> Hari Ini
            </button>
          </div>

          {{-- Filter Bulan --}}
          <div class="col-md-2">
            <label class="form-label fw-bold">Filter Bulan</label>
            <input type="month" class="form-control" id="filter-bulan" placeholder="Pilih bulan">
          </div>

          {{-- Filter Custom Range --}}
          <div class="col-md-2">
            <label class="form-label fw-bold">Tanggal Awal</label>
            <input type="date" class="form-control" id="tanggal-awal">
          </div>

          <div class="col-md-2">
            <label class="form-label fw-bold">Tanggal Akhir</label>
            <input type="date" class="form-control" id="tanggal-akhir">
          </div>

          <div class="col-auto">
            <button type="button" class="btn btn-secondary" id="btn-filter">
              <i class="ti ti-search"></i> Filter
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Periode Label --}}
  <div class="alert alert-info mb-4">
    <i class="ti ti-info-circle me-2"></i>
    Menampilkan data periode: <strong id="periode-label">Memuat...</strong>
  </div>

  {{-- Cards Ringkasan --}}
  <div class="row">
    {{-- Total Pendapatan --}}
    <div class="col-xl-3 col-sm-6 col-12 d-flex">
      <div class="card bg-primary sale-widget flex-fill">
        <div class="card-body d-flex align-items-center">
          <span class="sale-icon bg-white text-primary">
            <i class="ti ti-cash fs-24"></i>
          </span>
          <div class="ms-2">
            <p class="text-white mb-1">Total Pendapatan</p>
            <h4 class="text-white" id="total-pendapatan">Rp 0</h4>
          </div>
        </div>
      </div>
    </div>

    {{-- Total Transaksi --}}
    <div class="col-xl-3 col-sm-6 col-12 d-flex">
      <div class="card bg-success sale-widget flex-fill">
        <div class="card-body d-flex align-items-center">
          <span class="sale-icon bg-white text-success">
            <i class="ti ti-file-text fs-24"></i>
          </span>
          <div class="ms-2">
            <p class="text-white mb-1">Total Transaksi</p>
            <h4 class="text-white" id="total-transaksi">0</h4>
          </div>
        </div>
      </div>
    </div>

    {{-- Transaksi Pending --}}
    <div class="col-xl-3 col-sm-6 col-12 d-flex">
      <div class="card bg-warning sale-widget flex-fill">
        <div class="card-body d-flex align-items-center">
          <span class="sale-icon bg-white text-warning">
            <i class="ti ti-clock fs-24"></i>
          </span>
          <div class="ms-2">
            <p class="text-white mb-1">Pending/Proses</p>
            <h4 class="text-white" id="transaksi-pending">0</h4>
          </div>
        </div>
      </div>
    </div>

    {{-- Total Item Terjual --}}
    <div class="col-xl-3 col-sm-6 col-12 d-flex">
      <div class="card bg-info sale-widget flex-fill">
        <div class="card-body d-flex align-items-center">
          <span class="sale-icon bg-white text-info">
            <i class="ti ti-shopping-cart fs-24"></i>
          </span>
          <div class="ms-2">
            <p class="text-white mb-1">Total Item</p>
            <h4 class="text-white" id="total-item">0</h4>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    {{-- Grafik Penjualan --}}
    <div class="col-xl-8 d-flex">
      <div class="card flex-fill">
        <div class="card-header">
          <div class="d-inline-flex align-items-center">
            <span class="title-icon bg-soft-primary fs-16 me-2"><i class="ti ti-chart-line"></i></span>
            <h5 class="card-title mb-0">Grafik Penjualan</h5>
          </div>
        </div>
        <div class="card-body">
          <canvas id="chart-penjualan" height="300"></canvas>
        </div>
      </div>
    </div>

    {{-- Pendapatan per Kategori --}}
    <div class="col-xl-4 d-flex">
      <div class="card flex-fill">
        <div class="card-header">
          <div class="d-inline-flex align-items-center">
            <span class="title-icon bg-soft-info fs-16 me-2"><i class="ti ti-category"></i></span>
            <h5 class="card-title mb-0">Pendapatan per Kategori</h5>
          </div>
        </div>
        <div class="card-body" id="kategori-list">
          <p class="text-center text-muted">Memuat data...</p>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    {{-- Metode Pembayaran --}}
    <div class="col-xl-4 d-flex">
      <div class="card flex-fill">
        <div class="card-header">
          <div class="d-inline-flex align-items-center">
            <span class="title-icon bg-soft-success fs-16 me-2"><i class="ti ti-credit-card"></i></span>
            <h5 class="card-title mb-0">Jenis Transaksi</h5>
          </div>
        </div>
        <div class="card-body">
          <canvas id="chart-metode" height="200"></canvas>
        </div>
      </div>
    </div>

    {{-- Transaksi Terbaru --}}
    <div class="col-xl-8 d-flex">
      <div class="card flex-fill">
        <div class="card-header">
          <div class="d-inline-flex align-items-center">
            <span class="title-icon bg-soft-orange fs-16 me-2"><i class="ti ti-list"></i></span>
            <h5 class="card-title mb-0">Transaksi Terbaru</h5>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Kode</th>
                  <th>Meja</th>
                  <th>Kasir</th>
                  <th>Status</th>
                  <th>Total</th>
                  <th>Tanggal</th>
                </tr>
              </thead>
              <tbody id="transaksi-terbaru">
                <tr>
                  <td colspan="6" class="text-center text-muted">Memuat data...</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
  <script>
    let chartPenjualan = null;
    let chartMetode = null;

    // Set default tanggal hari ini
    function setDefaultDate() {
      const today = new Date().toISOString().split('T')[0];
      document.getElementById('tanggal-awal').value = today;
      document.getElementById('tanggal-akhir').value = today;
    }

    // Load Dashboard Data
    function loadDashboard(params = {}) {
      // Build query string
      const queryString = new URLSearchParams(params).toString();
      const url = '/dashboard/data' + (queryString ? '?' + queryString : '');

      console.log('Loading dashboard from:', url);

      fetch(url)
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(response => {
          console.log('Data loaded:', response);

          // Update Periode Label
          document.getElementById('periode-label').textContent = response.periode.label;

          // Update Cards
          document.getElementById('total-pendapatan').textContent = formatRupiah(response.ringkasan.total_pendapatan);
          document.getElementById('total-transaksi').textContent = response.ringkasan.total_transaksi;
          document.getElementById('transaksi-pending').textContent = response.ringkasan.transaksi_pending;
          document.getElementById('total-item').textContent = response.ringkasan.total_item;

          // Update Grafik Penjualan
          updateChartPenjualan(response.grafik_penjualan);

          // Update Kategori
          updateKategori(response.pendapatan_kategori);

          // Update Metode Pembayaran
          updateChartMetode(response.metode_pembayaran);

          // Update Transaksi Terbaru
          updateTransaksiTerbaru(response.transaksi_terbaru);
        })
        .catch(error => {
          console.error('Error loading dashboard:', error);
          alert('Gagal memuat data dashboard: ' + error.message);
        });
    }

    // Format Rupiah
    function formatRupiah(angka) {
      return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
    }

    // Update Chart Penjualan
    function updateChartPenjualan(data) {
      const ctx = document.getElementById('chart-penjualan');
      if (!ctx) return;

      if (chartPenjualan) {
        chartPenjualan.destroy();
      }

      chartPenjualan = new Chart(ctx.getContext('2d'), {
        type: 'line',
        data: {
          labels: data.map(item => item.tanggal),
          datasets: [{
            label: 'Pendapatan',
            data: data.map(item => item.pendapatan),
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.4
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: true
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                callback: function(value) {
                  return 'Rp ' + value.toLocaleString('id-ID');
                }
              }
            }
          }
        }
      });
    }

    // Update Kategori
    function updateKategori(data) {
      let html = '';
      if (data.length === 0) {
        html = '<p class="text-center text-muted">Tidak ada data</p>';
      } else {
        data.forEach(item => {
          html += `
            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
              <div>
                <h6 class="mb-1">${item.kategori}</h6>
                <p class="text-muted mb-0">${item.total_terjual} item</p>
              </div>
              <h5 class="text-primary mb-0">${formatRupiah(item.total_pendapatan)}</h5>
            </div>
          `;
        });
      }
      document.getElementById('kategori-list').innerHTML = html;
    }

    // Update Chart Metode
    function updateChartMetode(data) {
      const ctx = document.getElementById('chart-metode');
      if (!ctx) return;

      if (chartMetode) {
        chartMetode.destroy();
      }

      if (data.length === 0) {
        ctx.getContext('2d').fillText('Tidak ada data', 50, 100);
        return;
      }

      chartMetode = new Chart(ctx.getContext('2d'), {
        type: 'doughnut',
        data: {
          labels: data.map(item => item.jenis_transaksi === 'ditempat' ? 'Di Tempat' : 'Pesanan'),
          datasets: [{
            data: data.map(item => item.total),
            backgroundColor: [
              'rgba(54, 162, 235, 0.8)',
              'rgba(255, 206, 86, 0.8)'
            ]
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'bottom'
            }
          }
        }
      });
    }

    // Update Transaksi Terbaru
    function updateTransaksiTerbaru(data) {
      let html = '';
      if (data.length === 0) {
        html = '<tr><td colspan="6" class="text-center text-muted">Tidak ada data</td></tr>';
      } else {
        data.forEach(item => {
          const statusClass = {
            'selesai': 'success',
            'pending': 'warning',
            'proses': 'info',
            'keranjang': 'secondary',
            'batal': 'danger',
            'menanti': 'primary'
          };

          const mejaNomor = item.meja ? `Meja ${item.meja.nomor_meja}` : '-';

          html += `
            <tr>
              <td><span class="badge bg-light text-dark">${item.kode_transaksi}</span></td>
              <td>${mejaNomor}</td>
              <td>${item.kasir ? item.kasir.name : '-'}</td>
              <td><span class="badge badge-${statusClass[item.status]}">${item.status}</span></td>
              <td class="fw-bold">${formatRupiah(item.total_harga)}</td>
              <td>${new Date(item.created_at).toLocaleString('id-ID')}</td>
            </tr>
          `;
        });
      }
      document.getElementById('transaksi-terbaru').innerHTML = html;
    }

    // Event Listeners
    document.addEventListener('DOMContentLoaded', function() {
      console.log('Dashboard loaded, initializing...');

      // Set default tanggal
      setDefaultDate();

      // Load default (hari ini)
      loadDashboard();

      // Button Hari Ini
      document.getElementById('btn-today').addEventListener('click', function() {
        document.getElementById('filter-bulan').value = '';
        setDefaultDate();
        loadDashboard();
      });

      // Filter Bulan
      document.getElementById('filter-bulan').addEventListener('change', function() {
        const bulan = this.value;
        if (bulan) {
          document.getElementById('tanggal-awal').value = '';
          document.getElementById('tanggal-akhir').value = '';
          loadDashboard({ bulan: bulan });
        }
      });

      // Filter Custom Range
      document.getElementById('btn-filter').addEventListener('click', function() {
        const tanggalAwal = document.getElementById('tanggal-awal').value;
        const tanggalAkhir = document.getElementById('tanggal-akhir').value;

        if (tanggalAwal && tanggalAkhir) {
          document.getElementById('filter-bulan').value = '';
          loadDashboard({
            tanggal_awal: tanggalAwal,
            tanggal_akhir: tanggalAkhir
          });
        } else {
          alert('Pilih tanggal awal dan akhir');
        }
      });
    });
  </script>
</x-admin-panel>
