<?php

namespace App\Exports;

use App\Models\Perak;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PerakExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    private $no = 1;

    public function collection(): Collection
    {
        return Perak::all();
    }

    public function map($perak): array
    {
        return [
            $this->no++,
            $perak->kode_akd,
            $perak->semester == 'GL' ? 'Ganjil' : 'Genap',
            $perak->tahun,
            $perak->is_active == '1' ? 'Aktif' : 'Tidak Aktif'
        ];
    }
    
    public function headings(): array
    {
        return [
            'NO',
            'KODE AKADEMIK',
            'SEMESTER',
            'TAHUN',
            'STATUS'
        ];
    }

    public function styles(Worksheet $sheet): array|null
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}