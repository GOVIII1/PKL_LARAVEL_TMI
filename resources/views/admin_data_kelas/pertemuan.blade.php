<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @include('layouts.css')
</head>
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
          <i class="far fa-user"></i>
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
      @include('layouts.sidebar_admin')
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid"></div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        
        <!-- CARD INFO KELAS -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Kelas Matkul</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-6">
                <table class="table table-borderless">
                  <tr>
                    <td>Nama Kelas</td>
                    <td>:</td>
                    <td>{{ $kelas->nama_kelas }}</td>
                  </tr>
                  <tr>
                    <td>Tahun Akademik</td>
                    <td>:</td>
                    <td>{{ ($kelas->akademik->semester ?? '') == 'GL' ? 'Ganjil' : 'Genap' }} - {{ $kelas->akademik->tahun ?? '' }}</td>
                  </tr>
                  <tr>
                    <td>Nama Dosen</td>
                    <td>:</td>
                    <td>{{ $kelas->dosen->nama ?? '-' }}</td>
                  </tr>   
                  <tr>
                    <td>Persentase Kontrak</td>
                    <td>:</td>
                    <td>{{ $kelas->bobot_persen }} %</td>
                  </tr>            
                </table>
              </div>
              <div class="col-6">
                <table class="table table-borderless">
                  <tr>
                    <td>Nama Jurusan</td>
                    <td>:</td>
                    <td>{{ $kelas->jurusan->nama_jurusan ?? '-' }}</td>
                  </tr>
                  <tr>
                    <td>Nama Makul</td>
                    <td>:</td>
                    <td>{{ $kelas->makul->nama_makul ?? '-' }}</td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
        
        <!--card -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">List Pertemuan</h3>
          </div>
          <div class="card-body">
            <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i> Tambah Data</button>
            <button type="button" class="btn btn-warning mb-2" data-toggle="modal" data-target="#modal-persen"><i class="fas fa-edit"></i> Edit Persentase</button>
            
            <a href="{{ route('admin.kelas.cetak_rekap', $kelas->id) }}" target="_blank" class="btn btn-danger mb-2"><i class="fas fa-file-pdf"> Expor PDF rekap</i></a>
            <a href="{{ route('admin.pertemuan.cetak_pertemuan', $kelas->id) }}" class="btn btn-danger mb-2" target="_blank" type="button"><i class="fas fa-file-pdf"></i> Expor PDF Pertemuan</a>
            
            <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary mb-2">Kembali</a>
            
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th>Pertemuan Ke</th>
                  <th>Judul</th>
                  <th>Tanggal</th>
                  <th>Status Presensi</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($pertemuan as $data)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>Pertemuan Ke - {{ $data->pertemuan_ke }}</td>
                    <td>{{ $data->judul_pertemuan }}</td>
                    <td>{{ date('d F Y', strtotime($data->tanggal)) }}</td>
                    <td>{{ $data->status_presensi == '1' ? 'Aktif' : 'Tidak Aktif' }}</td>
                    <td>
                      <a href="{{ route('admin.presensi.index', $data->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-qrcode"></i> Presensi</a>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" align="center">Belum ada data pertemuan.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- tambah pertemuan -->
  <div class="modal fade" id="modal-tambah">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data Pertemuan</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form action="{{ route('admin.pertemuan.store') }}" method="post">
          @csrf
          <div class="modal-body">
            <input type="hidden" name="id_kelas" value="{{ $kelas->id }}">
            <div class="form-group">
              <label for="judul">Judul</label>
              <input type="text" name="judul_pertemuan" class="form-control" placeholder="Masukkan Judul" required>
            </div>
            <div class="form-group">
              <label for="tanggal">Tanggal</label>
              <input type="date" name="tanggal" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- modal update Persentase -->
  <div class="modal fade" id="modal-persen">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update Persentase</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form action="{{ route('admin.pertemuan.updatebobot') }}" method="post">
          @csrf
          <div class="modal-body">
            <input type="hidden" name="id_kelas" value="{{ $kelas->id }}">
            <div class="form-group">
              <label>Masukkan Persentase</label>
              <input type="number" name="bobot_persen" class="form-control" value="{{ $kelas->bobot_persen }}" required>
            </div>
          </div>    
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Main Footer -->
  @include('layouts.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
@include('layouts.script')

</body>
</html>