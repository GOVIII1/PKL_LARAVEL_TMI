<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Matkul;
use Maatwebsite\Excel\Concerns\WithStartRow;

class MatkulImport implements ToCollection, WithStartRow
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
            $kode_makul = $row[1]; //kolom b dst || kalo A = 0
            $nama_makul = $row[2];
            $jml_sks = $row[3];
            $jml_cpmk = $row[4];

            //skip data kosong
            if (empty($kode_makul) || empty($nama_makul) || empty($jml_sks) || empty($jml_cpmk)) {
                continue;
            }
            //cek duplikat data
            $cek_makul = Matkul::where('kode_makul', $kode_makul)->exists();
            //masukan ke tbl
            if (!$cek_makul) {
                Matkul::create([
                    'kode_makul' => $kode_makul,
                    'nama_makul' => $nama_makul,
                    'jml_sks' => $jml_sks,
                    'jml_cpmk' => $jml_cpmk
                ]);
            }
        }
    }
}
