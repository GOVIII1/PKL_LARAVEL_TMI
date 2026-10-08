<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Presensi - {{ $kelas->nama_kelas }}</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif; /* Sesuai FPDF lu yang pakai Times */
            font-size: 12px;
        }
        
        /* Kop Surat */
        .kop-surat {
            width: 100%;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            margin-bottom: 2px;
        }
        .kop-surat td {
            text-align: center;
        }
        .kop-surat h2 {
            margin: 0;
            font-size: 14px;
            font-weight: normal;
        }
        .kop-surat h3 {
            margin: 4px 0;
            font-size: 16px;
            font-weight: bold;
        }
        .kop-surat p {
            margin: 2px 0;
            font-size: 12px;
        }
        .garis-tipis {
            border-bottom: 1px solid black;
            margin-bottom: 15px;
        }

        /* Info Kelas (Tabel Tanpa Border) */
        .info-kelas {
            width: 100%;
            margin-bottom: 15px;
        }
        .info-kelas td {
            padding: 3px;
            vertical-align: top;
        }
        
        /* Tabel Data Presensi */
        .tabel-data {
            width: 100%;
            border-collapse: collapse;
        }
        .tabel-data th, .tabel-data td {
            border: 1px solid black;
            padding: 6px;
        }
        .tabel-data th {
            text-align: center;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Kop Surat -->
    <table class="kop-surat">
        <tr>
            <td width="15%">
                <img src="{{ public_path('asset_web/img/logopnc.png') }}" alt="Logo PNC" width="80">
            </td>
            <td width="85%">
                <h2>KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI</h2>
                <h3>POLITEKNIK NEGERI CILACAP</h3>
                <p>Jalan Dr. Soetomo No.1, Sidakaya - Cilacap 53212, Jawa Tengah</p>
                <p>Telepon: (0282) 533329, Fax: (0282) 537992</p>
            </td>
        </tr>
    </table>
    <!-- Garis tipis pelengkap kop surat -->
    <div class="garis-tipis"></div>

    <h3 class="text-center" style="margin-bottom: 20px;">LAPORAN PRESENSI</h3>

    <!-- Informasi Kelas -->
    <table class="info-kelas">
        <tr>
            <td width="20%">Periode Akademik</td>
            <td width="2%">:</td>
            <td width="38%">{{ $kelas->akademik->tahun }} - {{ $kelas->akademik->semester == 'GL' ? 'Ganjil' : 'Genap' }}</td>
            
            <td width="20%">Kelas</td>
            <td width="2%">:</td>
            <td width="18%">{{ $kelas->nama_kelas }}</td>
        </tr>
        <tr>
            <td>Mata Kuliah</td>
            <td>:</td>
            <td>{{ $kelas->makul->nama_makul }}</td>
            
            <td>Presentase Kontrak</td>
            <td>:</td>
            <td>{{ $kelas->bobot_persen }}%</td>
        </tr>
        <tr>
            <td>Prodi</td>
            <td>:</td>
            <td>{{ $kelas->jurusan->nama_jurusan }}</td>
            
            <td>Dosen</td>
            <td>:</td>
            <td>{{ $kelas->dosen->nama }}</td>
        </tr>
        <tr>
            <td>Total Pertemuan</td>
            <td>:</td>
            <td>{{ $total_pertemuan }}</td>
            
            <td colspan="3"></td>
        </tr>
    </table>

    <!-- Tabel Utama Data Kehadiran -->
    <table class="tabel-data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="45%">Mahasiswa</th>
                <th width="15%">Jml Kehadiran</th>
                <th width="15%">% Kehadiran</th>
                <th width="20%">Kontrak</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekap_presensi as $data)
            <tr>
                <td class="text-center">{{ $data['no'] }}</td>
                <td>{{ $data['nim'] }} - {{ $data['nama'] }}</td>
                <td class="text-center">{{ $data['jml_hadir'] }}</td>
                <td class="text-center">{{ number_format($data['persentase_hadir'], 1) }}%</td>
                <td class="text-center">{{ number_format($data['persentase_kontrak'], 1) }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>