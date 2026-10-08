<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Presensi - {{ $kelas->nama_kelas }}</title>
    <style>
        /* 1. Kasih jarak dari atas kertas biar header fix nggak nabrak tulisan */
        @page {
            margin-top: 130px; 
            margin-bottom: 40px;
        }
        body { font-family: "Times New Roman", Times, serif; font-size: 12px; }

        /* 2. Ini pengganti function Header() di FPDF */
        header {
            position: fixed;
            top: -110px; /* Ditarik ke atas mengisi area margin @page */
            left: 0px;
            right: 0px;
            height: 100px;
        }

        .kop-surat { width: 100%; border-bottom: 3px solid black; padding-bottom: 10px; margin-bottom: 2px; }
        .kop-surat td { text-align: center; }
        .kop-surat h2 { margin: 0; font-size: 14px; font-weight: normal; }
        .kop-surat h3 { margin: 4px 0; font-size: 16px; font-weight: bold; }
        .kop-surat p { margin: 2px 0; font-size: 12px; }
        .garis-tipis { border-bottom: 1px solid black; margin-bottom: 15px; }
        
        .info-kelas { width: 100%; margin-bottom: 20px; font-size: 11px; }
        .info-kelas td { padding: 3px; vertical-align: top; }
        
        /* Tambahan page-break-inside biar tabel nggak kepotong di tengah-tengah halaman */
        .meeting-box { page-break-inside: avoid; margin-bottom: 20px; }
        .meeting-header { width: 100%; font-weight: bold; font-size: 11px; margin-bottom: 3px; }
        .meeting-header td { padding: 2px; }
        
        .tabel-data { width: 100%; border-collapse: collapse; margin-top: 5px; }
        .tabel-data th, .tabel-data td { border: 1px solid black; padding: 5px; }
        .tabel-data th { text-align: center; font-weight: bold; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <!-- HEADER FIXED: Bagian ini bakal di-print ulang di setiap ujung atas halaman baru -->
    <header>
        <table class="kop-surat">
            <tr>
                <td width="15%"><img src="{{ public_path('asset_web/img/logopnc.png') }}" width="80"></td>
                <td width="85%">
                    <h2>KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI</h2>
                    <h3>POLITEKNIK NEGERI CILACAP</h3>
                    <p>Jalan Dr. Soetomo No.1, Sidakaya - Cilacap 53212, Jawa Tengah</p>
                    <p>Telepon: (0282) 533329, Fax: (0282) 537992</p>
                </td>
            </tr>
        </table>
        <div class="garis-tipis"></div>
    </header>

    <!-- MAIN CONTENT: Bagian ini yang datanya memanjang ke bawah -->
    <main>
        <h3 class="text-center" style="margin-bottom: 15px;">LAPORAN PRESENSI</h3>

        <table class="info-kelas">
            <tr>
                <td width="15%">Periode Akademik</td><td width="2%">:</td><td width="33%">{{ $kelas->akademik->tahun }} - {{ $kelas->akademik->semester == 'GL' ? 'Ganjil' : 'Genap' }}</td>
                <td width="15%">Mata Kuliah</td><td width="2%">:</td><td width="33%">{{ $kelas->makul->nama_makul }}</td>
            </tr>
            <tr>
                <td>Prodi</td><td>:</td><td>{{ $kelas->jurusan->nama_jurusan }}</td>
                <td>Total Pertemuan</td><td>:</td><td>{{ $total_pertemuan }}</td>
            </tr>
            <tr>
                <td>Kelas</td><td>:</td><td>{{ $kelas->nama_kelas }}</td>
                <td>Presentase Kontrak</td><td>:</td><td>{{ $kelas->bobot_persen }}%</td>
            </tr>
            <tr>
                <td>Dosen</td><td>:</td><td>{{ $kelas->dosen->nama }}</td>
                <td colspan="3"></td>
            </tr>
        </table>

        @foreach($pertemuan as $prt)
            <div class="meeting-box">
                <table class="meeting-header">
                    <tr>
                        <td width="20%">Pertemuan Ke {{ $prt->pertemuan_ke }}</td>
                        <td width="55%">{{ $prt->judul_pertemuan }}</td>
                        <td width="25%" style="text-align: right;">{{ \Carbon\Carbon::parse($prt->tanggal)->translatedFormat('d F Y') }}</td>
                    </tr>
                </table>

                <table class="tabel-data">
                    <thead>
                        <tr>
                            <th width="8%">No</th>
                            <th width="62%">Mahasiswa</th>
                            <th width="30%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($prt->presensi->count() > 0)
                            @foreach($prt->presensi as $index => $presensi)
                                @php
                                    $status = '';
                                    if ($presensi->status_kehadiran == '1') $status = 'alpha';
                                    elseif ($presensi->status_kehadiran == '2') $status = 'hadir';
                                    elseif ($presensi->status_kehadiran == '3') $status = 'sakit';
                                    elseif ($presensi->status_kehadiran == '4') $status = 'izin';
                                    else $status = 'dispen';
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $presensi->nim }} - {{ $presensi->mahasiswa ? $presensi->mahasiswa->nama : 'Nama Tidak Ditemukan' }}</td>
                                    <td class="text-center">{{ $status }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada data presensi untuk pertemuan ini</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        @endforeach
    </main>
</body>
</html>