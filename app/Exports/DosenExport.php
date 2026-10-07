<?php

namespace App\Exports;

use App\Models\Dosen;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\withHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DosenExport implements FromCollection, withHeadings, WithMapping,ShouldAutoSize, WithStyles
{
    private $no =1;
    
    public function collection(): Collection
    {
        return Dosen::all();
    }

    public function map($dosen): array
    {
        return [
            $this->no++,
            $dosen->nik,
            $dosen->nama,
            $dosen->kontak,
            $dosen->email,
            $dosen->kelamin =='l' ? 'Laki-Laki' : 'Perempuan'
        ];
    }

    public function headings(): array
    {
        return [
            'NO',
            'NIK',
            'NAMA',
            'KONTAK',
            'EMAIL',
            'JENIS_KELAMIN'
        ];
    }

    public function styles(Worksheet $sheet): array|null
    {
        return [
            1 => ['font' => ['bold' =>true]],
        ];
    }
}
