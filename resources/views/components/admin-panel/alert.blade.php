@if (session('success'))
  <div class="modal fade modal-sweet" id="modal-success" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body text-center">
          <span class="rounded-circle d-inline-flex p-2 bg-success-transparent mb-2">
            <i class="ti ti-checks fs-24 text-success"></i>
          </span>
          <h4 class="fs-20 fw-semibold">Sukses</h4>
          <p>{{ session('success') }}</p>
          <a href="#" class="btn btn-primary close-sweet-modal" data-target="#modal-success">Tutup</a>
        </div>
      </div>
    </div>
  </div>
@endif

@if (session('error'))
  <div class="modal fade modal-sweet" id="modal-error" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body text-center">
          <span class="rounded-circle d-inline-flex p-2 bg-danger-transparent mb-2">
            <i class="ti ti-x fs-24 text-danger"></i>
          </span>
          <h4 class="fs-20 fw-semibold">Gagal</h4>
          <p>{{ session('error') }}</p>
          <a href="#" class="btn btn-primary close-sweet-modal" data-target="#modal-error">Tutup</a>
        </div>
      </div>
    </div>
  </div>
@endif

@if ($errors->any())
  <div class="modal fade modal-sweet" id="modal-validation-error" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body text-center">
          <span class="rounded-circle d-inline-flex p-2 bg-danger-transparent mb-2">
            <i class="ti ti-alert-triangle fs-24 text-danger"></i>
          </span>
          <h4 class="fs-20 fw-semibold">Validasi Gagal</h4>
          <ul class="list-unstyled">
            @foreach ($errors->all() as $error)
              <li class="text-danger">{{ $error }}</li>
            @endforeach
          </ul>
          <a href="#" class="btn btn-primary close-sweet-modal" data-target="#modal-validation-error">Tutup</a>
        </div>
      </div>
    </div>
  </div>
@endif

{{-- modal alert hapus data --}}
<div class="modal fade modal-sweet" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-center">
        <div class="modal-body p-4">
          <span class="rounded-circle d-inline-flex p-2 bg-danger-transparent mb-3">
            <i class="ti ti-trash fs-24 text-danger"></i>
          </span>
          <h4 class="fs-20 fw-semibold">Yakin Hapus?</h4>
          <p id="deleteModalMessage" class="mb-3"></p>

          <form id="deleteModalForm" method="POST">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Hapus</button>
          </form>
        </div>
      </div>
    </div>
  </div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    @if (session('success'))
      new bootstrap.Modal(document.getElementById('modal-success')).show();
    @endif

    @if (session('error'))
      new bootstrap.Modal(document.getElementById('modal-error')).show();
    @endif

    @if ($errors->any())
      new bootstrap.Modal(document.getElementById('modal-validation-error')).show();
    @endif
  });

  function confirmDelete(routeUrl, itemName) {
    const message = `Apakah kamu yakin ingin menghapus <strong>${itemName}</strong>?`;
    document.getElementById('deleteModalMessage').innerHTML = message;

    const form = document.getElementById('deleteModalForm');
    form.setAttribute('action', routeUrl);

    const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
    modal.show();
  }

  document.querySelectorAll('.close-sweet-modal').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      const targetId = btn.getAttribute('data-target');
      const modal = document.querySelector(targetId);
      const dialog = modal.querySelector('.modal-dialog');

      modal.classList.remove('show');
      modal.classList.add('hide');

      dialog.style.animation = 'sweetZoomOut 0.5s ease-in forwards';

      setTimeout(() => {
        const bsModal = bootstrap.Modal.getInstance(modal);
        if (bsModal) bsModal.hide();
        modal.classList.remove('hide');
      }, 300); // waktu harus sama dengan durasi animasi zoomOut
    });
  });
</script>

<style>
  @keyframes sweetZoomIn {
    from {
      opacity: 0;
      transform: scale(0.7);
    }

    to {
      opacity: 1;
      transform: scale(1);
    }
  }

  @keyframes sweetZoomOut {
    from {
      opacity: 1;
      transform: scale(1);
    }

    to {
      opacity: 0;
      transform: scale(0.7);
    }
  }

  .modal-sweet.modal.fade.show .modal-dialog {
    animation: sweetZoomIn 0.3s ease-out forwards;
  }

  .modal-sweet.modal.fade.hide .modal-dialog {
    animation: sweetZoomOut 0.3s ease-in forwards;
  }

  .modal-sweet .modal-dialog {
    transition: none !important;
    transform: none !important;
  }

  .modal-sweet .modal-content {
    border-radius: 1rem;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
  }

  .bg-success-transparent {
    background-color: rgba(25, 135, 84, 0.1);
  }

  .bg-danger-transparent {
    background-color: rgba(220, 53, 69, 0.1);
  }

  .btn-danger,
  .btn-primary {
    padding: 6px 16px;
    font-weight: 500;
    border-radius: 0.5rem;
  }
</style>
