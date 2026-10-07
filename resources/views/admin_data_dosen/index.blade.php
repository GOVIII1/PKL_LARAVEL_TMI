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
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
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
          <a href="{{route('logout')}}" class="dropdown-item">
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
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Dosen</h3>
          </div>
          <div class="card-body">
            <button type="button" class="btn btn-danger mb-2" data-toggle="modal" data-target="#modal-tambah">
              <i class="fas fa-plus"></i> Tambah Data
            </button>
            <form action="{{ route('admin.dosen.reset') }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin mereset SELURUH data dosen?')">
                @csrf
                <button type="submit" class="btn btn-danger mb-2"><i class="fas fa-exclamation-triangle"></i> Reset Data</button>
            </form>
            <a href="{{ route('admin.dosen.cetak_pdf') }}" class="btn btn-danger mb-2" target="_blank" type="button"><i class="fas fa-file-pdf"> Export pdf</i></a>
            <a href="{{ route('admin.dosen.export_excel') }}" class="btn btn-success mb-2" target="_blank" type="button"><i class="fas fa-file-pdf">Export Excel</i></a>
            <button type="button" class="btn btn-danger mb-2" data-toggle="modal" data-target="#modal-download"><i class="fas fa-download"></i> Download Template excel</button>
            <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modal-impor"><i class="fas fa-file-excel"></i> Impor Data Excel</button>
            <a href="{{ route('admin.dosen.export_excel') }}" class="btn btn-success mb-2" target="_blank" type="button"><i class="fas fa-file-pdf"> Export Excel</i></a>

            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th>NIK</th>
                  <th>Nama</th>
                  <th>Kontak</th>
                  <th>Email</th>
                  <th>Kelamin</th>
                  <th>Foto</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($dosen as $data)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $data->nik }}</td>
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
                    <button type="button" class="btn btn-sm p-0" style="background: transparent; border: none;" data-toggle="modal" data-target="#modal-foto" data-nik="{{ $data->nik }}">
                      @if(!empty($data->img))
                      <img src="{{ asset(str_replace('../','',$data->img)) }}" alt="Foto Dosen" width="50px" class="img-thumbnail">
                      @else
                      <img src="{{ asset($data->kelamin == 'l' ? 'uploads/dosen/dosen_laki.jpg' : 'uploads/dosen/dosen_perempuan.jpg') }}" alt="Foto Dosen" width="50px" class="img-thumbnail">
                      @endif
                    </button>
                  </td>
                  <td>
                    <a href="{{ route('admin.dosen.edit', $data->nik) }}" type="button" class="btn btn-warning btn-sm">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="{{ route('admin.dosen.destroy', $data->nik) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Hapus?')">
                      <i class="fas fa-trash"></i>
                    </a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->

  <aside class="control-sidebar control-sidebar-dark"></aside>

  <!-- Modal Tambah Data Dosen -->
  <div class="modal fade" id="modal-tambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahLabel">Tambah Data Dosen</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form action="{{ route('admin.dosen.store') }}" method="POST">
          @csrf
          <div class="modal-body">

            <div class="form-group">
              <label for="nik">NIK</label>
              <input type="text" name="nik" id="nik" class="form-control" placeholder="Masukkan NIK" required>
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
            <button type="submit" class="btn btn-primary">Tambah</button>
          </div>
        </form>

      </div>
    </div>
  </div>

  <!-- modal edit foto -->
  <div class="modal fade" id="modal-foto">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Foto Dosen</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post" enctype="multipart/form-data" id="form-foto">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <input type="hidden" name="nik" id="modal-nik">
              <label for="file">Upload Foto Dosen</label>
              <input type="file" class="form-control" name="file_foto" required accept="image/*">
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary" name="btn_foto">simpan</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
        <form action="{{ route('admin.dosen.impor_excel') }}" method="post" enctype="multipart/form-data">
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
            <a href="{{ asset('template/template_dosen.xls') }}" download class="btn btn-success">Download File</a>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  @include('layouts.footer')
</div>
<!-- ./wrapper -->

@include('layouts.script')
<script>
  $('#modal-foto').on('show.bs.modal', function (e) {
    var nik = $(e.relatedTarget).data('nik');
    $('#modal-nik').val(nik);
    var url = "{{ url('/admin/dosen/update_foto') }}/" + nik;
    $('#form-foto').attr('action', url);
  });
</script>
</body>
</html>
