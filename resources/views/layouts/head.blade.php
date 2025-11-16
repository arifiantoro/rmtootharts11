<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>Rekam Medis</title>
  <!-- Fonts and icons -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.2.0') }}" rel="stylesheet" />

  <!-- DataTables CSS -->
  {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"> --}}

  <!-- Bootstrap CSS (kalau belum ada) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<!-- DataTables Buttons CSS (untuk export) -->
<link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<!-- DataTables Bootstrap 5 CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<!-- DataTables Buttons CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

<style>
    /* Hapus style default datatables */
    table.dataTable thead th, 
    table.dataTable thead td {
        border-bottom: none !important;
    }

    table.dataTable tbody tr {
        background-color: transparent !important;
    }

    /* Style untuk tombol */
    .btn-edit {
        @apply px-3 py-1 rounded bg-yellow-500 text-white hover:bg-yellow-600;
    }
    .btn-delete {
        @apply px-3 py-1 rounded bg-red-500 text-white hover:bg-red-600;
    }

    /* Badge */
    .badge-laki {
        @apply px-2 py-1 rounded text-xs font-bold bg-blue-500 text-white;
    }
    .badge-perempuan {
        @apply px-2 py-1 rounded text-xs font-bold bg-pink-500 text-white;
    }

    /* Registrasi */
    .badge-reg {
        @apply px-2 py-1 rounded text-sm bg-gray-300 text-gray-800;
    }
</style>


</head>
<body class="g-sidenav-show bg-gray-100">
