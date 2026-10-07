<!DOCTYPE html>
<html lang="en">
@include('layouts.css')
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
          {{ session('nama') }} - [{{ session('user')['peran'] ?? 'a' }}]<i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profil
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
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
      @include('layouts.sidebar_admin')
      <!-- /.sidebar-menu -->
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
  <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <div class="card-primary card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-lock"></i> Ganti Password</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.password.proses') }}" method="POST">
                            @csrf
                        <div class="form-group">
                            <label for="password_lama">Password Lama</label>
                            <input type="password" name="password_lama" class="form-control"
                            placeholder="Input Password lama" required >
                        </div>
                        <div class="form-group">
                            <label for="password_baru">Password Baru</label>
                            <input type="password" name="password_baru" class="form-control"
                            placeholder="Input Password baru max 10 char" maxlength="10" required >
                        </div>
                        <div class="form-group">
                            <label for="pin">PIN</label>
                            <input type="number" name="pin" class="form-control"
                            placeholder="Input PIN" maxlength="6" required >
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block" name="btn_edit">
                                <i class="fas fa-edit"> Edit</i>
                            </button>
                        </form>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    <!-- /.content -->
      </div>
      </div>
</div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  @include('layouts.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
@include('layouts.script')
<script>
    @if(session('error')) alert("{{ session('error') }}"); @endif
    @if(session('success')) alert("{{ session('success') }}"); @endif
</script>
</body>
</html>
