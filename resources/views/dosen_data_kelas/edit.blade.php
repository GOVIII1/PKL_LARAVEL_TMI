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
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
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
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
              <span class="brand-text font-weight-light">SISTEM MANAJEMEN</span>
            </a>
            <div class="sidebar">
                @include('layouts.sidebar_admin')
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit Data Kelas Mata Kuliah</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.kelas.update', $kelas->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="kode_akd">Pilih Akademik</label>
                                    <select name="kode_akd" class="form-control" id="kode_akd" required>
                                        <option value="">Pilih Akademik</option>
                                            @foreach ($periode as $p)
                                            <option value="{{ $p->kode_akd }}" {{ $kelas->kode_akd == $p->kode_akd ? 'selected' :''}}>
                                                {{ $p->semester == 'GL' ? 'Ganjil' : 'Genap' }} - {{ $p->tahun }}
                                            </option>
                                            @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="kode_makul">Pilih Mata Kuliah</label>
                                    <select name="kode_makul" class="form-control" id="kode_makul" required>
                                        <option value="">Pilih Mata Kuliah</option>
                                        @foreach ($makul as $m)
                                            <option value="{{ $m->kode_makul }}" {{ $kelas->kode_makul == $m->kode_makul ? 'selected': ''}}>
                                                {{ $m->nama_makul }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="kode_jurusan">Pilih Jurusan</label>
                                    <select name="kode_jurusan" class="form-control" id="kode_jurusan" required>
                                        <option value="">Pilih Jurusan</option>
                                        @foreach ($jurusan as $j)
                                        <option value="{{ $j->kode_jurusan }}" {{  $kelas->kode_jurusan == $j->kode_jurusan ? 'selected' :''}}>
                                            {{ $j->nama_jurusan }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nik">Pilih Dosen</label>
                                    <select name="nik" class="form-control" id="nik" required>
                                    <option value="">Pilih Dosen</option>
                                    @foreach ($dosen as $d)
                                    <option value="{{ $d->nik }}" {{ $kelas->nik == $d->nik ? 'selected' : '' }}>
                                        {{ $d->nama }}
                                    </option>     
                                    @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nama_kelas">Nama Kelas</label>
                                    <input type="text" name="nama_kelas" class="form-control" id="nama_kelas" 
                                    placeholder="Masukkan nama kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required>
                                </div>
                                
                                <a href="{{ route('admin.kelas.index') }}" class="btn btn-success btn-block">Tutup</a> 
                                <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid"></div>
            </div>
        </div>
        <!-- /.content-wrapper -->

        <aside class="control-sidebar control-sidebar-dark"></aside>

        @include('layouts.footer')
    </div>
    <!-- ./wrapper -->

    @include('layouts.script')
</body>

</html>
