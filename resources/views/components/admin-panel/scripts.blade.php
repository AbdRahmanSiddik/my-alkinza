<link href="https://unpkg.com/slim-select@latest/dist/slimselect.css" rel="stylesheet">
<script src="{{ asset('assets/uploadImg/script.js') }}"></script>

<!-- jQuery -->
<script src="{{ asset('') }}assets/js/jquery-3.7.1.min.js" type="cac43e468e49c8eaad120038-text/javascript"></script>

<!-- Feather Icon JS -->
<script src="{{ asset('') }}assets/js/feather.min.js" type="cac43e468e49c8eaad120038-text/javascript"></script>

<!-- Slimscroll JS -->
<script src="{{ asset('') }}assets/js/jquery.slimscroll.min.js" type="cac43e468e49c8eaad120038-text/javascript"></script>

<!-- Datatable JS -->
<script src="{{ asset('') }}assets/js/jquery.dataTables.min.js" type="cac43e468e49c8eaad120038-text/javascript"></script>
<script src="{{ asset('') }}assets/js/dataTables.bootstrap5.min.js" type="cac43e468e49c8eaad120038-text/javascript"></script>

<!-- Bootstrap Core JS -->
<script src="{{ asset('') }}assets/js/bootstrap.bundle.min.js" type="cac43e468e49c8eaad120038-text/javascript"></script>

<!-- Select2 JS -->
<script src="{{ asset('') }}assets/plugins/select2/js/select2.min.js" type="cac43e468e49c8eaad120038-text/javascript"></script>

<!-- Datetimepicker JS -->
<script src="{{ asset('') }}assets/js/moment.min.js" type="cac43e468e49c8eaad120038-text/javascript"></script>
<script src="{{ asset('') }}assets/js/bootstrap-datetimepicker.min.js" type="cac43e468e49c8eaad120038-text/javascript"></script>

<!-- Color Picker JS -->
<script src="{{ asset('') }}assets/plugins/%40simonwep/pickr/pickr.es5.min.js" type="cac43e468e49c8eaad120038-text/javascript"></script>

<!-- Custom JS -->
<script src="{{ asset('') }}assets/js/theme-colorpicker.js" type="cac43e468e49c8eaad120038-text/javascript"></script>
<script src="{{ asset('') }}assets/js/script.js" type="cac43e468e49c8eaad120038-text/javascript"></script>



<script src="{{ asset('') }}assets/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js"
  data-cf-settings="cac43e468e49c8eaad120038-|49" defer></script>
<script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
  integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
  data-cf-beacon='{"rayId":"92c84d950e514ac7","version":"2025.3.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}'
  crossorigin="anonymous"></script>

<script>
   document.addEventListener('DOMContentLoaded', function () {
    // Inisialisasi semua tooltip
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Feather icons
    if (typeof feather !== 'undefined') {
      feather.replace();
    }

    // Dinamis modal trigger
    document.querySelectorAll('[data-modal-target]').forEach(el => {
      el.addEventListener('click', function () {
        const targetSelector = el.getAttribute('data-modal-target');
        const modalEl = document.querySelector(targetSelector);
        if (modalEl) {
          const modal = new bootstrap.Modal(modalEl);
          modal.show();
        }
      });
    });
  });
</script>
