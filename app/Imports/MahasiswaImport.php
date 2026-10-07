<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Mahasiswa;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithStartRow;

class MahasiswaImport implements ToCollection, WithStartRow
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
            //pemetaan kolom
            $nim = $row[1]; //kolom b dst
            $nama = $row[2];
            $kontak = $row[3];
            $email = $row[4];
            $kelamin = $row[5];

            //skip data kosong
            if (empty($nim) || empty($nama) || empty($kontak) || empty($email) || empty($kelamin)) {
                continue;
            }
        
            $pin = sha1('123456');
            $password = sha1($nim);
            //cek
            $cek_mahasiswa = Mahasiswa::where('nim', $nim)->exists();
            $cek_user = User::where('username', $nim)->exists();
            //masukna
            if (!$cek_mahasiswa && !$cek_user) {
                Mahasiswa::create([
                    'nim' => $nim,
                    'nama' => $nama,
                    'kontak' => $kontak,
                    'email' => $email,
                    'kelamin' => $kelamin
                ]);
                User::create([
                    'username' => $nim,
                    'password' => $password,
                    'peran' => 'm',
                    'pin' => $pin,
                    'nama' => $nama
                ]);
            }
        }
    }
}
