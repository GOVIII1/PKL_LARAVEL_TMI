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
      <div class="container-fluid">
        
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        
        <!-- card  -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Detail Kelas Matkul</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="35%">Nama Kelas</td>
                                <td width="5%">:</td>
                                <td>{{ $kelas->nama_kelas }}</td>
                            </tr>
                            <tr>
                                <td>Tahun Akademik</td>
                                <td>:</td>
                                <td>
                                    {{ $kelas->akademik->tahun ?? '-' }} - {{ ($kelas->akademik->semester ?? '') == 'GL' ? 'Ganjil' : 'Genap' }}
                                </td>
                            </tr>
                            <tr>
                                <td>Nama Dosen</td>
                                <td>:</td>
                                <td>{{ $kelas->dosen->nama ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="35%">Nama Jurusan</td>
                                <td width="5%">:</td>
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

        <!-- card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Mahasiswa Kelas</h3>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-danger mb-2" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i> Tambah Data</button>
                <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modal-impor"><i class="fas fa-file-excel"></i> Impor Data</button>
                <a href="{{ route('admin.detail.kelas.export_excel') }}" target="_blank" class="btn btn-success mb-2"><i class="fas fa-file-excel"></i> Export Data excel</a>
                <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary mb-2">Kembali</a>

                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th width="12%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($detail as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nim }}</td>
                                <td>{{ $item->mahasiswa->nama ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.detail.kelas.hapus', $item->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" align="center">Belum ada data mahasiswa di kelas ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- modal tambah  -->
  <div class="modal fade" id="modal-tambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Data Mahasiswa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.detail.kelas.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_klsmk" value="{{ $kelas->id }}">

                    <div class="form-group">
                        <label for="nim">Mahasiswa</label>
                        <select name="nim" class="form-control" id="nim" required>
                            <option value="">-- Pilih Mahasiswa --</option>
                            @foreach ($mahasiswa as $mhs)
                                <option value="{{ $mhs->nim }}">{{ $mhs->nim }} - {{ $mhs->nama }}</option>
                            @endforeach
                        </select>
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

  <!-- modal impor -->
  <div class="modal fade" id="modal-impor">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Impor Data Detail Kelas Matkul</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <label>Download Template :</label>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-download-template" data-dismiss="modal">
                            <i class="fas fa-download"></i> Download Template
                        </button>
                    </div>
                    <div class="form-group">
                        <label for="file">Upload File Detail Kelas Matkul</label>
                        <input type="file" class="form-control" name="file_excel" required>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Impor</button>
                </div>
            </form>
        </div>
    </div>
  </div>

  <!-- modal download template -->
  <div class="modal fade" id="modal-download-template">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Download Template</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Silahkan download file template di bawah ini:</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <a href="{{ asset('template/template_detail_kelas_matkul.xls') }}" class="btn btn-primary" download>
                    Download File
                </a>
            </div>
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