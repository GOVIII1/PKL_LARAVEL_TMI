<?php

namespace App\Exports;

use App\Models\Matkul;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MatkulExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    private $no = 1;

    public function collection(): Collection
    {
        return Matkul::all();
    }

    public function map($matkul): array
    {
        return [
            $this->no++,
            $matkul->kode_makul,
            $matkul->nama_makul,
            $matkul->jml_sks,
            $matkul->jml_cpmk
        ];
    }

    public function headings(): array
    {
        return [
            'NO',
            'KODE MATKUL',
            'NAMA MATKUL',
            'JUMLAH SKS',
            'JUMLAH CPMK'
        ];
    }

    public function styles(Worksheet $sheet): array|null
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
