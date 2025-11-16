@include('layouts.head')
<body class="g-sidenav-show bg-gray-100">
  <div class="wrapper">
    @include('layouts.sidebar')
    <main class="main-content position-relative border-radius-lg">
      @include('layouts.navbar')
      <div class="container-fluid py-4">
        @yield('content')
        @include('layouts.footer')
      </div>
    </main>
  </div>

<!-- DataTables Bootstrap 5 CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

  <!-- Bootstrap 5 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Material Dashboard Core -->
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
  <script src="{{ asset('assets/js/material-dashboard.min.js?v=3.2.0') }}"></script>

  <!-- DataTables Init -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#anggota-table').DataTable({
            pagingType: "simple_numbers",
            lengthMenu: [5, 10, 25, 50],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari pasien..."
            },
            dom: '<"row mb-3"<"col-sm-6"f><"col-sm-6 text-end"l>>t<"row mt-3"<"col-sm-6"i><"col-sm-6"p>>',
            paging: true,
            info: true,
            responsive: true
        });
    });

    function confirmDelete(event) {
        if (!confirm("Apakah yakin ingin menghapus pasien ini?")) {
            event.preventDefault();
        }
    }

    // Scrollbar init untuk Windows
    if (navigator.platform.indexOf('Win') > -1 && document.querySelector('#sidenav-scrollbar')) {
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), { damping: '0.5' });
    }
  </script>
  @stack('scripts')
</body>
</html>
