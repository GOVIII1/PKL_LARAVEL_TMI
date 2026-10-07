<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MahasiswaExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    private $no = 1;
    public function collection(): Collection
    {
        return Mahasiswa::all();
    }
    //mapping data perbaris
    public function map($mahasiswa): array
    {
        return [
            $this->no++,
            $mahasiswa->nim,
            $mahasiswa->nama,
            $mahasiswa->kontak,
            $mahasiswa->email,
            $mahasiswa->kelamin == 'l' ? 'Laki-Laki' : 'perempuan'
        ];
    }

    //header
    public function headings(): array
    {
        return [
            'NO',
            'NIM',
            'NAMA',
            'KONTAK',
            'EMAIL',
            'JENIS KELAMIN'
        ];
    }

    //style baris pertama
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
