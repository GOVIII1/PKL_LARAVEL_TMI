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
                            <h3 class="card-title">Edit Data Periode Akademik</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.perak.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="kode_akd">Kode Akademik</label>
                                    <input value="{{ old('kode_akd',$perak->kode_akd) }}" type="text" maxlength="10" name="kode_akd" class="form-control" id="kode_akd" placeholder="Masukkan Kode Akademik" readonly>
                                </div>
                                <div class="form-group">
                                        <label>Semester</label>
                                        <select class="form-control" name="semester" required>
                                        <option value="">Pilih Semester</option>
                                        <option value="GL" {{ old('semester',$perak->semester) == 'GL' ? 'selected':'' }}>Ganjil (GL)</option>
                                        <option value="GN" {{ old('semester',$perak->semester) == 'GN' ? 'selected':'' }}>Genap (GN)</option>
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label for="tahun">Tahun</label>
                                    <input value="{{ old('tahun',$perak->tahun) }}" type="number" maxlength="4" name="tahun" class="form-control" id="tahun" placeholder="Masukkan Tahun (Contoh: 2026)" required>
                                </div>
                                <div class="form-group">
                                        <label>Status Aktif</label>
                                        <select class="form-control" name="is_active" required>
                                        <option value="">Pilih Status</option>
                                        <option value="1" {{ old('is_active',$perak->is_active) == '1' ? 'selected':'' }} >Aktif</option>
                                        <option value="0" {{ old('is_active',$perak->is_active) == '0' ? 'selected':'' }}>Tidak Aktif</option>
                                        </select>
                                </div>
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
