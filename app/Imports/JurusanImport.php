<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Jurusan;
use Maatwebsite\Excel\Concerns\WithStartRow;

class JurusanImport implements ToCollection, WithStartRow
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
        foreach ($rows as $row){
            $kode_jurusan = $row[1];
            $nama_jurusan = $row[2];

            if (empty($kode_jurusan) || empty($nama_jurusan)) {
                continue;
            }

            $cek_jurusan = Jurusan::where('kode_jurusan', $kode_jurusan)->exists();

            if (!$cek_jurusan){
                Jurusan::create([
                    'kode_jurusan' => $kode_jurusan,
                    'nama_jurusan' => $nama_jurusan
                ]);
            }
        }
    }
}
