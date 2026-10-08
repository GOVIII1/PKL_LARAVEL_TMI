<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\DetailKelas;

class DetailKelasImport implements ToCollection,WithStartRow
{
    protected $id_kelas;
    public function __construct($id_kelas)
    {
        $this->id_kelas = $id_kelas;
    }
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
            $nim = $row[1];

            if (empty($nim)) {
                continue;
            }

            //khusu detail ngeceknya idklsmk sama nim
            $cek_data = DetailKelas::where('id_klsmk', $this->id_kelas)
            ->where('nim', $nim)
            ->exists();

            if (!$cek_data){
                DetailKelas::create([
                    'id_klsmk' => $this->id_kelas, //dari variabel global constructor
                    'nim' => $nim
                ]);
            }
        }
    }
}
