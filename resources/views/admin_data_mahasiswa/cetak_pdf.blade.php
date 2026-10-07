<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak PDF Data Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }
        
        /* styling khusus kop surat */
        .kop-surat {
            width: 100%;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-surat td {
            text-align: center;
        }
        .kop-surat h2 {
            margin: 0;
            font-size: 18px;
        }
        .kop-surat h3 {
            margin: 4px 0;
            font-size: 16px;
        }
        .kop-surat p {
            margin: 0;
            font-size: 10px;
        }
        
        /* styling khusus tabel data */
        .tabel-data {
            width: 100%;
            border-collapse: collapse;
        }
        .tabel-data th, .tabel-data td {
            border: 1px solid black;
            padding: 6px;
        }
        .tabel-data th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- kop surat -->
    <table class="kop-surat">
        <tr>
            <!-- logo -->
            <td width="15%">
                <img src="{{ public_path('asset_web/img/logopnc.png') }}" alt="Logo PNC" width="80">
            </td>
            <!-- teks -->
            <td width="70%">
                <h2>Jurusan Komputer dan Bisnis</h2>
                <h3>Prodi Informatika</h3>
                <p>Jalan Dr. Soetomo Nomor 1, Kelurahan Sidakaya, Kecamatan Cilacap Selatan,</p>
                <p>Kabupaten Cilacap, Provinsi Jawa Tengah, kode pos 53212</p>
            </td>
            <td width="15%"></td>
        </tr>
    </table>

    <h3 class="text-center" style="margin-bottom: 15px;">Data Mahasiswa</h3>

    <!-- tabel -->
    <table class="tabel-data">
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="15%">NIM</th>
                <th width="30%">Nama</th>
                <th width="15%">Kontak</th>
                <th width="20%">Email</th>
                <th width="15%">Jenis Kelamin</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($mahasiswa as $data)
            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td class="text-center">{{ $data->nim }}</td>
                <td>{{ $data->nama }}</td>
                <td class="text-center">{{ $data->kontak }}</td>
                <td>{{ $data->email }}</td>
                <td class="text-center">{{ $data->kelamin == 'l' ? 'Laki-Laki' : 'Perempuan' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>