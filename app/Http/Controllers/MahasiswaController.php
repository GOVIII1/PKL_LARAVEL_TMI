<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\MahasiswaExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MahasiswaImport;

class MahasiswaController extends Controller
{
    public function index(){
        $mahasiswa = Mahasiswa::all();
        $hal = 'data_mahasiswa';
        return view('admin_data_mahasiswa.index', compact('mahasiswa', 'hal'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nim'     => 'required|string',
            'nama'    => 'required|string',
            'kontak'  => 'required|string',
            'email'   => 'required|email',
            'kelamin' => 'required|string'
        ]);

        $nim = $request->nim;

        $mahasiswaExist = Mahasiswa::where('nim', $nim)->exists();
        if ($mahasiswaExist) {
            return redirect()->route('admin.mahasiswa.index')
            ->with('error', 'NIM Sudah Terdaftar di tabel Mahasiswa!');
        }

        $userExist = User::where('username', $nim)->exists();
        if ($userExist) {
            return redirect()->route('admin.mahasiswa.index')
            ->with('error', 'NIM sudah terdaftar di tabel user! Tidak bisa menambahkan.');
        }

        DB::beginTransaction();
        try {
            $mhs = new Mahasiswa();
            $mhs->nim = $nim;
            $mhs->nama = $request->nama;
            $mhs->kontak = $request->kontak;
            $mhs->email = $request->email;
            $mhs->kelamin = $request->kelamin;
            $mhs->save();

            $user = new User();
            $user->username = $nim;
            $user->password = sha1($nim);
            $user->peran = 'm';
            $user->pin = sha1('123456');
            $user->nama = $request->nama;
            $user->save();
            
            DB::commit();

            return redirect()->route('admin.mahasiswa.index')
                             ->with('success', 'Data Berhasil Disimpan');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.mahasiswa.index')
                             ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
    
    public function destroy($nim)
    {
        $mahasiswa = Mahasiswa::find($nim);

        if ($mahasiswa && !empty($mahasiswa->img)) {
            $cleanPath = str_replace('../', '', $mahasiswa->img);
            $oldPath = public_path($cleanPath);

            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }
        }

        if ($mahasiswa) {
            $mahasiswa->delete();
        }
        
        $user = User::where('username', $nim)->first();
        if ($user) {
            $user->delete();
        }

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data mahasiswa Berhasil Dihapus');
    }

    public function edit($nim){
        $mahasiswa = Mahasiswa::findOrFail($nim);
        $hal = 'data_mahasiswa';
        return view('admin_data_mahasiswa.edit', compact('mahasiswa', 'hal'));
    }

    public function update(Request $request, $nim){
        $request->validate([
            'nama' => 'required',
            'kontak' => 'required',
            'email' => 'required|email',
            'kelamin' => 'required',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($nim);
        $mahasiswa->nama = $request->nama;
        $mahasiswa->kontak = $request->kontak;
        $mahasiswa->email = $request->email;
        $mahasiswa->kelamin = $request->kelamin;
        $mahasiswa->save();

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data mahasiswa berhasil diperbarui!');
    }

    public function update_foto(Request $request, $nim)
    {
        $request->validate([
            'file_foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);
        
        $mahasiswa = Mahasiswa::findOrFail($nim);
        
        if ($request->hasFile('file_foto')) {
            $file = $request->file('file_foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            if (!empty($mahasiswa->img)) {
                $cleanPath = str_replace('../', '', $mahasiswa->img);
                $oldPath = public_path($cleanPath);

                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $file->move(public_path('uploads/mahasiswa'), $filename);

            $mahasiswa->img = 'uploads/mahasiswa/' . $filename;
            $mahasiswa->save();
            
            return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Foto Mahasiswa Berhasil Diperbaharui');
        }
    }

    public function reset()
    {
        DB::beginTransaction();
        try {
            Mahasiswa::query()->delete();
            User::where('peran','m')->delete();

            $folderFoto = public_path('uploads/mahasiswa');
            if (File::exists($folderFoto)) {
                File::cleanDirectory($folderFoto);
            }

            DB::commit();
            return redirect()->route('admin.mahasiswa.index')->with('success', 'Seluruh data mahasiswa berhasil direset');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.mahasiswa.index')->with('error', 'Gagal mereset data: ' . $e->getMessage());
        }
    }

    public function ganti_password()
    {
        return view('mahasiswa_ganti_password.index');
    }

    public function proses_ganti_password(Request $request)
    {
        $userSession = session('user');
        $username = $userSession['username'];

        $user = User::where('username', $username)->first();

        $input_password_lama = sha1(trim($request->password_lama));
        $input_password_baru = sha1(trim($request->password_baru));
        $input_pin = sha1(trim($request->pin));

        if ($input_password_lama === $user->password && $input_pin === $user->pin) {
            $user->password = $input_password_baru;
            $user->save();

            return redirect()->back()->with('success', 'Password Berhasil di update!');
        } else {
            return redirect()->back()->with('error', 'Password/Pin salah');
        }
    }

    public function cetak_pdf()
    {
        $mahasiswa= Mahasiswa::all();
        //load html ke odf
        $pdf = Pdf::loadView('admin_data_mahasiswa.cetak_pdf', compact('mahasiswa'));
        $pdf->setPaper('A4', 'portrait');
        //render pdf
        return $pdf->stream('Data_Mahasiswa.pdf');
    }

    public function export_excel()
    {
        $nama_file = 'Data_mahasiswa_' . date('Y-m-d') . '.xlsx';
        return Excel::download(new MahasiswaExport, $nama_file);
    }
    
    public function import_excel(Request $request)
    {
        $file = $request->file('file_excel');
        Excel::import(new MahasiswaImport, $file);
        return redirect()->back()->with('success', 'Impor data berhasil');
    }
}