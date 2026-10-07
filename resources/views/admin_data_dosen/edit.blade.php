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
                            <h3 class="card-title">Edit Data Dosen</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.dosen.update', $dosen->nik) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="nik">NIK</label>
                                    <input type="text" class="form-control" name="nik" id="nik"
                                        value="{{ $dosen->nik }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" name="nama" id="nama"
                                        value="{{ old('nama', $dosen->nama) }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="kontak">Kontak</label>
                                    <input type="number" name="kontak" id="kontak" maxlength="13"
                                        class="form-control" value="{{ old('kontak', $dosen->kontak) }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        value="{{ old('email', $dosen->email) }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="kelamin">Jenis Kelamin</label>
                                    <select name="kelamin" id="kelamin" class="form-control" required>
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="l" {{ old('kelamin', $dosen->kelamin) == 'l' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="p" {{ old('kelamin', $dosen->kelamin) == 'p' ? 'selected' : '' }}>Perempuan</option>
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
