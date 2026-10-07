<?php

namespace App\Exports;

use App\Models\Jurusan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JurusanExport implements FromCollection, WithHeadings,WithMapping,ShouldAutoSize,WithStyles
{
    private $no = 1;

    public function collection(): Collection
    {
        return Jurusan::all();
    }

    public function map($jurusan): array
    {
        return [
            $this->no++,
            $jurusan->kode_jurusan,
            $jurusan->nama_jurusan
        ];
    }

    public function headings(): array
    {
        return [
            'NO',
            'KODE JURUSAN',
            'NAMA JURUSAN'
        ];
    }

    public function styles(Worksheet $sheet): array|null
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
