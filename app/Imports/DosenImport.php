<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Dosen;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DosenImport implements ToCollection, WithStartRow
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
            $nik = $row[1]; //kolom b dst
            $nama = $row[2];
            $kontak = $row[3];
            $email = $row[4];
            $kelamin = $row[5];

            //skip data kosong
            if (empty($nik) || empty($nama) || empty($kontak) || empty($email) || empty($kelamin)) {
                continue;
            }
        
            $pin = sha1('696969');
            $password = sha1($nik);
            //cek
            $cek_dosen = Dosen::where('nik', $nik)->exists();
            $cek_user = User::where('username', $nik)->exists();
            //masukna
            if (!$cek_dosen && !$cek_user) {
                dosen::create([
                    'nik' => $nik,
                    'nama' => $nama,
                    'kontak' => $kontak,
                    'email' => $email,
                    'kelamin' => $kelamin
                ]);
                User::create([
                    'username' => $nik,
                    'password' => $password,
                    'peran' => 'd',
                    'pin' => $pin,
                    'nama' => $nama
                ]);
            }
        }
    }
}
