{{-- <div class="container">
  <div class="row g-2">
    @forelse ($meja as $item)
      @php
        $jenis = $aktif[$item->id] ?? null;
        $btnClass = 'btn-primary';
        $disabled = false;

        if ($jenis === 'pesanan') {
            $btnClass = 'btn-secondary';
            $disabled = true;
        } elseif ($jenis === 'ditempat') {
            $btnClass = 'btn-outline-primary';
        }
      @endphp

      <div class="col-3">
        <button class="btn {{ $btnClass }} meja-btn w-100" data-id="{{ $item->id }}"
          data-nomor="{{ $item->nomor_meja }}" @if ($disabled) disabled @endif>
          {{ $item->nomor_meja }}
        </button>
      </div>
    @empty
      <div class="col-12 text-center">
        <p class="fw-bold text-muted">Belum ada meja yang terdaftar</p>
      </div>
    @endforelse

  </div>
</div> --}}

<div class="container">
  <div class="row g-2">
    @forelse ($meja as $item)
      @php
        $jenis = $aktif[$item->id] ?? null;

        // Mapping status ke class dan disabled
        $statusMap = [
            'pesanan'   => ['btn-secondary', true],
            'ditempat'  => ['btn-outline-primary', false],
            // Tambahkan status lain di sini jika perlu
        ];

        [$btnClass, $disabled] = $statusMap[$jenis] ?? ['btn-primary', false];
      @endphp

      <div class="col-3">
        <button class="btn {{ $btnClass }} meja-btn w-100"
                data-id="{{ $item->id }}"
                data-nomor="{{ $item->nomor_meja }}"
                @if ($disabled) disabled @endif>
          {{ $item->nomor_meja }}
        </button>
      </div>
    @empty
      <div class="col-12 text-center">
        <p class="fw-bold text-muted">Belum ada meja yang terdaftar</p>
      </div>
    @endforelse
  </div>
</div>
