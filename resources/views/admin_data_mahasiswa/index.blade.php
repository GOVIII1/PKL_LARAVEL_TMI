<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  @include('layouts.css')
  @if (session('error'))
    <script>
        alert("{{ session('error') }}");
    </script>
  @endif

  @if (session('success'))
      <script>
          alert("{{ session('success') }}");
      </script>
  @endif
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
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <span class="brand-text font-weight-light">SISTEM MANAJEMEN</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

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
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Mahasiswa</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <button type="button" class="btn btn-danger mb-2"data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i> Tambah Data</button>
                <form action="{{ route('admin.mahasiswa.reset')}}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin mereset seluruh data mahasiswa?')">
                  @csrf
                  <button type="submit" class="btn btn-danger mb-2">
                    <i class="fas fa-exclamation-triangle"></i>Reset Data
                  </button>
                </form>
                <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modal-impor"><i class="fas fa-file-excel"></i> Impor Data Excel</button>
                <button type="button" class="btn btn-danger mb-2" data-toggle="modal" data-target="#modal-download"><i class="fas fa-download"></i> Download Template</button>
                <a href="{{ route('admin.mahasiswa.cetak_pdf') }}" class="btn btn-danger mb-2" target="_blank" type="button"><i class="fas fa-file-pdf"> Export pdf</i></a>
                <a href="{{ route('admin.mahasiswa.export_excel') }}" class="btn btn-success mb-2" target="_blank" type="button"><i class="fas fa-file-pdf"> Export Excel</i></a>

                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <td width="5%">no</td>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Kontak</th>
                    <th>Email</th>
                    <th>Kelamin</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($mahasiswa as $data)
                     <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->nim }}</td>
                        <td>{{ $data->nama }}</td>
                        <td>{{ $data->kontak }}</td>
                        <td>{{ $data->email }}</td>
                        <td>
                            @if($data->kelamin == 'l')
                             Laki-Laki
                            @else
                             Perempuan
                            @endif
                        </td>
                        <td align="center">
                            <button type="button" class="btn btn-sm" style="background: transparent; border: none;" data-toggle="modal" data-target="#modal-foto" data-nim="{{ $data->nim }}">
                                @if(!empty($data->img))
                                <img src="{{ asset(str_replace('../', '', $data->img)) }}" alt="Foto Mahasiswa" width="50px" class="img-thumbnail">
                                @else
                                <img src="{{ asset($data->kelamin == 'l' ? 'uploads/mahasiswa/mahasiswa_laki.jpg' : 'uploads/mahasiswa/mahasiswa_perempuan.jpg') }}" alt="Foto" width="50px" class="img-thumbnails">
                                @endif
                            </button>
                        </td>
                        <td>
                            <a href="{{route('admin.mahasiswa.edit', $data->nim)}}" type="button" class="btn btn-warning btn-sm">
                              <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('admin.mahasiswa.destroy', $data->nim) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Hapus?')">
                              <i class="fas fa-trash"></i>
                            </a>
                        </td>
                     </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                  
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
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

  <!-- Main Footer -->
  <!-- Modal Tambah Data Mahasiswa -->
      <div class="modal fade" id="modal-tambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            
            <div class="modal-header">
              <h5 class="modal-title" id="modalTambahLabel">Tambah Data Mahasiswa</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form action="{{ route('admin.mahasiswa.store') }}" method="POST">
              @csrf
              <div class="modal-body">
                
                <div class="form-group">
                  <label for="nim">NIM</label>
                  <input type="text" name="nim" id="nim" class="form-control" placeholder="Masukkan nim" required>
                </div>

                <div class="form-group">
                  <label for="nama">Nama</label>
                  <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Nama" required>
                </div>

                <div class="form-group">
                  <label for="kontak">Kontak</label>
                  <input type="text" name="kontak" id="kontak" class="form-control" placeholder="Masukkan Kontak" required>
                </div>

                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan Email" required>
                </div>

                <div class="form-group">
                  <label for="kelamin">Kelamin</label>
                  <select name="kelamin" id="kelamin" class="form-control" required>
                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                    <option value="l">Laki-Laki</option>
                    <option value="p">Perempuan</option>
                  </select>
                </div>

              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" name="btn_tambah_mahasiswa" class="btn btn-primary">Tambah</button>
              </div>
            </form>

          </div>
        </div>
      </div>
     <!-- Modal impor-->
      <div class="modal fade" id="modal-impor">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Impor Data </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('admin.mahasiswa.impor_excel') }}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="modal-body">
                <div class="form-group">
                  <label for="file">Upload File Template</label>
                  <input type="file" class="form-control" name="file_excel" required >
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" name="btn_impor">Impor</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
       <!-- Modal download-->
      <div class="modal fade" id="modal-download">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Download Template </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
              <div class="modal-body">
                <div class="form-group">
                  <p>Silahkan Download Template Berikut</p>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <a href="{{ asset('template/template_mahasiswa.xls') }}" download class="btn btn-success">Download File</a>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
       <div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Data Mahasiswa </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="ubah.php" method="post">
            <div class="modal-body">
              <div class="form-group">
                    <label for="nim">NIM</label>
                    <input type="number" maxlength="10" name="nim" class="form-control" id="nim" placeholder="Masukkan nim" readonly>
                  </div>
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan Nama" required>
                  </div>
                  <div class="form-group">
                    <label for="kontak">Kontak</label>
                    <input type="number" maxlength="13" name="kontak" class="form-control" id="kontak" placeholder="Masukkan Kontak" required>
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" maxlength="100" name="email" class="form-control" id="email" placeholder="Masukkan Email" required>
                  </div>
                  <!-- select -->
                      <div class="form-group">
                        <label>Kelamin</label>
                        <select class="form-control" name="kelamin">
                          <option>Pilih Jenis Kelamin</option>
                          <option value="l">Laki-Laki</option>
                          <option value="p">Perempuan</option>
                        </select>
                      </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary" name="btn_edit">Edit</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
       <!-- Modal edit foto -->
      <div class="modal fade" id="modal-foto">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Foto Mahasiswa </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="" method="post" enctype="multipart/form-data" id="form-foto">
              @csrf
              <div class="modal-body">
                <div class="form-group">
                  <input type="hidden" name="nim" id="modal-nim">
                  <label for="file">Upload Foto Mahasiswa </label>
                  <input type="file" class="form-control" name="file_foto" required accept="image/*">
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" name="btn_foto">Simpan</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
  @include('layouts.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

@include('layouts.script')

<script>
  $('#modal-edit').on('show.bs.modal', function (e){
    var nim = $(e.relatedTarget).data('nim');
    var nama = $(e.relatedTarget).data('nama');
    var kontak = $(e.relatedTarget).data('kontak');
    var email = $(e.relatedTarget).data('email');
    var kelamin = $(e.relatedTarget).data('kelamin');

    $(e.currentTarget).find('input[name="nim"]').val(nim);
    $(e.currentTarget).find('input[name="nama"]').val(nama);
    $(e.currentTarget).find('input[name="kontak"]').val(kontak);
    $(e.currentTarget).find('input[name="email"]').val(email);
    $(e.currentTarget).find('select[name="kelamin"]').val(kelamin);
  });

  $('#modal-foto').on('show.bs.modal', function(e){
    var nim = $(e.relatedTarget).data('nim');
    $('#modal-nim').val(nim);
    var url = "{{ url('/admin/mahasiswa/update_foto')}}/" + nim;
    $('#form-foto').attr('action', url);
  });
</script>
</body>
</html>
<?php 
?>