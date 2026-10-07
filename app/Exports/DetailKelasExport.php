<?php

namespace App\Exports;

use App\Models\DetailKelas;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DetailKelasExport implements FromCollection, WithHeadings,WithMapping,ShouldAutoSize,WithStyles
{
    private $no = 1;
    public function collection(): Collection
    {
        return DetailKelas::with('mahasiswa')->get();
    }

    public function map($detailkelas): array
    {
        return [
            $this->no++,
            $detailkelas->nim,
            $detailkelas->mahasiswa ? $detailkelas->mahasiswa->nama : 'Nama Tidak Ditemukan'
        ];
    }

    public function headings(): array
    {
        return [
            'NO',
            'NIM',
            'NAMA'
        ];
    }

    public function styles(Worksheet $sheet): array|null
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
