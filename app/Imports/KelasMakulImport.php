<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\DetailKelas;
use Maatwebsite\Excel\Concerns\WithStartRow;

class KelasMakulImport implements ToCollection, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $akademik = trim($row[1]);
            $matkul = trim($row[2]);
            $jurusan = trim($row[3]);
            $dosen = trim($row[4]);
            $nama_kelas = trim($row[5]);
            $mahasiswa = trim($row[6]);
            
            if (empty($akademik) || empty($matkul) || empty($jurusan) || empty($dosen) || empty($nama_kelas) || empty($mahasiswa)) {
                continue;
            }

            //cek kelas
            $kelas = Kelas::where('kode_akd', $akademik)
                          ->where('kode_makul', $matkul)
                          ->where('kode_jurusan', $jurusan)
                          ->where('nik', $dosen)
                          ->where('nama_kelas', $nama_kelas)
                          ->first();

            //kalo belum buat
            if (!$kelas) {
                $kelas = Kelas::create([
                    'kode_akd'     => $akademik,
                    'kode_makul'   => $matkul,
                    'kode_jurusan' => $jurusan,
                    'nik'          => $dosen,
                    'nama_kelas'   => $nama_kelas
                ]);

                
            }

            if ($kelas && $kelas->id) {
            $mhs_valid = Mahasiswa::where('nim', $mahasiswa)->exists();
            
            if ($mhs_valid) {
                DetailKelas::firstOrCreate([
                    'id_klsmk' => $kelas->id,
                    'nim' => $mahasiswa
                ]);
            }
            }
        }
    }
}
