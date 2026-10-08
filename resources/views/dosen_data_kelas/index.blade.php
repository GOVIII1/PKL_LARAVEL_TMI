<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  @include('layouts.css')
</head>
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

    <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-user"></i> {{ session('user.nama') }} - [{{ session('user.peran') }}]
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profil
          </a>
          <div class="dropdown-divider"></div>
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

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">Sistem Manajemen</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      @include('layouts.sidebar_dosen')
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        
        <form action="{{ route('dosen.kelas.index') }}" method="get">
            @csrf
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <select name="kode_akd" class="form-control">
                            @foreach ($periode as $p)
                                <option value="{{  $p->kode_akd }}">{{ $p->tahun}} - {{($p->semester) == 'GL' ? 'Ganjil' : 'Genap' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <button type="submit" class="btn btn-primary" name="cari"><i class="fas fa-search"> Tampilkan Data</i></button>
                </div>
            </div>
        </form>
        @if (request()->has('kode_akd'))
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Kelas Matkul</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="example1">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Kelas</th>
                                <th>Akademik</th>
                                <th>Mata Kuliah</th>
                                <th>Dosen</th>
                                <th>Jurusan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kelas as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->nama_kelas }}</td>
                                    <td>{{ $data->akademik->tahun ?? '-' }} - {{ ($data->akademik->semester ??'') == 'GL' ? 'Ganjil' :'Genap' }}</td>
                                    <td>{{ $data->makul->nama_makul ?? '-' }}</td>
                                    <td>{{ $data->dosen->nama ?? '-' }}</td>
                                    <td>{{ $data->jurusan->nama_jurusan ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('dosen.detail.kelas.index', $data->id )}}" class="btn btn-primary btn-sm"><i class="fas fa-list"></i> detail</a>
                                        <a href="{{ route('dosen.pertemuan.index', $data->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-th"></i> pertemuan</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" align="center">Tidak Ada Data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

      <!-- /.modal -->
  <!-- Main Footer -->
  @include('layouts.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
@include('layouts.script')

</body>
</html>