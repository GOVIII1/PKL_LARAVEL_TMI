<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Perak;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PerakImport implements ToCollection, WithStartRow
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
            $kode_akd = $row[1];
            $semester = $row[2];
            $tahun = $row[3];
            $is_active = $row[4];

            if (empty($kode_akd) || empty($semester) || empty($tahun) || $is_active === null || $is_active === '') {
                continue;
            }

            $cek_perak = Perak::where('kode_akd', $kode_akd)->exists();

            if (!$cek_perak){
                Perak::create([
                    'kode_akd' => $kode_akd,
                    'semester' => $semester,
                    'tahun' => $tahun,
                    'is_active' => $is_active
                ]);
            }
        }
    }
}
