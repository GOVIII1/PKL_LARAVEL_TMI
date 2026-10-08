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

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">SISTEM MANAJEMEN</a>
        </div>
      </div>
      @include('layouts.sidebar_dosen')
    </div>
  </aside>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid"></div> 
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="card card-primary">
          <div class="card-header">
             <h3 title="kelas_matkul">Kelas Mata Kuliah : {{ $kelas->id }}</h3>
          </div>

          <div class="card-body">                    
            <div class="row">
              
              <!-- kol 1 -->
              <div class="col-3 text-center">
                <div class="card pt-3 px-3">
                  @if (($kelas->dosen->kelamin ?? '') == 'l')
                      <img src="{{ !empty($kelas->dosen->img) ? asset($kelas->dosen->img) : asset('asset_web/img/dosen_lk.jpg') }}" alt='Foto Laki-Laki' class='img-fluid mx-auto d-block' width='200px'>                      
                  @else
                      <img src="{{ !empty($kelas->dosen->img) ? asset($kelas->dosen->img) : asset('asset_web/img/dosen_pr.jpg') }}" alt='Foto Perempuan' class='img-fluid mx-auto d-block' width='200px'>
                  @endif

                  @if ($pertemuan->status_presensi == '1')
                    <a href="{{ route('dosen.presensi.buka.tutup', ['id' => $pertemuan->id, 'aksi' => 'tutup']) }}" class="btn btn-danger w-100 mt-3" onclick="return confirm('Apakah anda yakin ingin menutup presensi ini?')">Tutup Presensi</a>
                  @else
                    <a href="{{ route('dosen.presensi.buka.tutup', ['id' => $pertemuan->id, 'aksi' => 'buka']) }}" class="btn btn-success w-100 mt-3" onclick="return confirm('Apakah anda yakin ingin membuka presensi ini?')">Buka Presensi</a>
                  @endif
                </div>                    
              </div>

              <!-- col 2 -->
              <div class="col-5">
                <div class="card">
                  <div class="card-body">
                    <table class="table table-borderless table-sm">
                      <tr><td>NIK</td><td>:</td><td>{{ $kelas->dosen->nik ?? '-' }}</td></tr>
                      <tr><td>Nama</td><td>:</td><td>{{ $kelas->dosen->nama ?? '-' }}</td></tr>
                      <tr><td>Mata Kuliah</td><td>:</td><td>{{ $kelas->makul->nama_makul ?? '-' }}</td></tr>
                      <tr><td>Judul Materi</td><td>:</td><td>{{ $pertemuan->judul_pertemuan }}</td></tr>
                      <tr><td>Kelas</td><td>:</td><td>{{ $kelas->nama_kelas }}</td></tr>
                      <tr><td>Jurusan</td><td>:</td><td>{{ $kelas->jurusan->nama_jurusan ?? '-' }}</td></tr>
                      <tr><td>Hari</td><td>:</td><td>{{ date('l', strtotime($pertemuan->tanggal)) }}</td></tr>
                      <tr><td>Tanggal</td><td>:</td><td>{{ date('d F Y', strtotime($pertemuan->tanggal)) }}</td></tr>
                      <tr><td>Pertemuan ke</td><td>:</td><td>{{ $pertemuan->pertemuan_ke }}</td></tr>
                    </table>
                  </div>
                </div>
              </div>

              <!-- col 3 qr code -->
              <div class="col-3">
                <div class="text-center">
                  <div class="card pt-3 px-3">
                    <!-- qr code -->
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $pertemuan->id }}" alt='QR Code' class='img-fluid mx-auto d-block' width='200px'>
                    
                    <div class="mt-2">
                      <p>Scan QR untuk <br> melakukan presensi</p>
                      <p id="waktu-mundur" class="mt-2 text-danger font-weight-bold text-center"></p>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- kol tb ajax -->
              <div class="col-12 mt-3">
                <div id="presensi">
                    <p class="text-center"><i>Memuat tabel presensi...</i></p>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

    <!-- modal edit -->
     <div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Data Status Kehadiran</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('dosen.presensi.update.status') }}" method="post">
                @csrf
            <div class="modal-body">
                      <div class="form-group">
                        <label>Status Kehadiran</label>
                        <input type="hidden" name="id" value="" hidden>
                        <input type="hidden" name="id_pertemuan" value="{{ $pertemuan->id }}">
                        <select class="form-control" name="status_kehadiran">
                          <option>Pilih Status Kehadiran</option>
                          <option value="1">Alpha</option>
                          <option value="2">Hadir</option>
                          <option value="3">Sakit</option>
                          <option value="4">Izin</option>
                          <option value="5">Dispen</option>
                        </select>
                      </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary" name="btn_edit_status">Tambah</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
  @include('layouts.footer')
</div>

@include('layouts.script')

<!-- countdown beda sama native-->
<script>
  // Key unik per pertemuan biar memori browser ga bentrok
  var storageKey = "waktu_absen_pertemuan_{{ $pertemuan->id }}";

  @if ($pertemuan->status_presensi == '1')
      var savedEndTime = localStorage.getItem(storageKey);
      var endTime;

      if (savedEndTime) {
          // Lanjutin waktu dari memori (biar aman dari F5)
          endTime = parseInt(savedEndTime);
      } else {
          // Set 5 menit dari sekarang & simpan ke memori
          endTime = new Date().getTime() + (5 * 60 * 1000);
          localStorage.setItem(storageKey, endTime);
      }

      var x = setInterval(function() {
        var now = new Date().getTime();
        var distance = endTime - now;

        if (distance < 0) {
          // Timer habis
          clearInterval(x);
          document.getElementById("waktu-mundur").innerHTML = "Presensi Ditutup";
          
          // Bersihkan memori
          localStorage.removeItem(storageKey);
          
          // Auto-tutup absen ke database
          window.location.href = "{{ route('dosen.presensi.buka.tutup', ['id' => $pertemuan->id, 'aksi' => 'tutup']) }}";
        } else {
          // Hitung & tampilkan sisa waktu
          var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
          var seconds = Math.floor((distance % (1000 * 60)) / 1000);
          document.getElementById("waktu-mundur").innerHTML = "Sisa waktu presensi: "+ minutes + "m " + seconds + "s ";
        }
      }, 1000);

  @else
      // Hapus memori waktu kalau absen ditutup manual sama dosen
      localStorage.removeItem(storageKey);
  @endif
</script>

<!-- ajax load table -->
<script>
  function refresh_tabel(){
      $('#presensi').load('{{ route('dosen.presensi.tabel', $pertemuan->id) }}');
      setTimeout(refresh_tabel, 2000);
  };
  
  $(document).ready(function(){
      refresh_tabel();
  });
</script>

<script>
  $('#modal-edit').on('show.bs.modal', function (e){
    var id = $(e.relatedTarget).data('id');
    var status_kehadiran = $(e.relatedTarget).data('status_kehadiran');

    $(e.currentTarget).find('input[name="id"]').val(id);
    $(e.currentTarget).find('select[name="status_kehadiran"]').val(status_kehadiran);
  });
</script>

</body>
</html>