<!DOCTYPE html>
<html lang="en">

@include('layouts.css')
<?php $hal = 'mhs_presensi';?>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
   <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->

      <!-- Messages Dropdown Menu -->
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          {{ session('nama') }} - [{{ session('peran') }}]<i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profil
          </a>
          <div class="dropdown-divider"></div>
          <!-- Link logout disesuaikan ke Laravel -->
          <a href="{{ route('logout') }}" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> Keluar
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->


    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        
        <div class="info">
          <a href="#" class="d-block">SISTEM MANAJEMEN</a>
        </div>
      </div>

      <!-- Sidebar Menu --> 
      @include('layouts.sidebar_mahasiswa')
      <!-- /.sidebar-menu -->
       </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
    
    <!-- /.content-header -->
      </div> 
    </div>
  
  <!-- Main content -->
  <section class="content">
      <div class="container-fluid">
        <label class="">PRESENSI</label>
        <div id="reader" style="width: 600px"></div>
    <!-- /.content -->
      </div>
  </section>
  </div>
  <!-- /.content-wrapper -->

  <!-- ControFl Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  @include('layouts.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

@include('layouts.script')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    function onScanSuccess(decodedText, decodedResult) {
    // Handle on success condition with the decoded text or result.
    //console.log(`Scan result: ${decodedText}`, decodedResult);
    
    // Cuma ubah ini aja arahnya ke Route Laravel yang nanti kita buat
    window.location.href='/mahasiswa_presensi/proses/'+decodedText;
    }

    const html5QrcodeScanner = new Html5QrcodeScanner(
    "reader", { fps: 10, qrbox: 250 });
    html5QrcodeScanner.render(onScanSuccess);
</script>

<!-- notif presensi -->
<script>
    @if(session('error'))
        alert("{{ session('error') }}");
    @endif

    @if(session('warning'))
        alert("{{ session('warning') }}");
    @endif

    @if(session('success'))
        alert("{{ session('success') }}");
    @endif
</script>
</body>
</html>