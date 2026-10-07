<?php

namespace App\Http\Controllers;

use App\Exports\MahasiswaExport;
use App\Imports\DosenImport;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\DosenExport;
use Maatwebsite\Excel\Facades\Excel;

class DosenController extends Controller
{
    public function index()
    {
        $dosen = Dosen::all();
        $hal = 'data_dosen';
        return view('admin_data_dosen.index', compact('dosen', 'hal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik'     => 'required|string',
            'nama'    => 'required|string',
            'kontak'  => 'required|string',
            'email'   => 'required|email',
            'kelamin' => 'required|string',
        ]);

        $nik = $request->nik;
        $dosenExist = Dosen::where('nik', $nik)->exists();
        if ($dosenExist) {
            return redirect()->route('admin.dosen.index')
                ->with('error', 'NIK Sudah Terdaftar di tabel Dosen!');
        }

        $userExist = User::where('username', $nik)->exists();
        if ($userExist) {
            return redirect()->route('admin.dosen.index')
                ->with('error', 'NIK sudah terdaftar di tabel user! Tidak bisa menambahkan.');
        }

        DB::beginTransaction();
        try {
            $dosen = new Dosen();
            $dosen->nik = $nik;
            $dosen->nama = $request->nama;
            $dosen->kontak = $request->kontak;
            $dosen->email = $request->email;
            $dosen->kelamin = $request->kelamin;
            $dosen->save();

            $user = new User();
            $user->username = $nik;
            $user->password = sha1($nik);
            $user->peran = 'd';
            $user->pin = sha1('123456');
            $user->nama = $request->nama;
            $user->save();

            DB::commit();

            return redirect()->route('admin.dosen.index')
                ->with('success', 'Data Berhasil Disimpan');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.dosen.index')
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function edit($nik)
    {
        $dosen = Dosen::findOrFail($nik);
        $hal = 'data_dosen';
        return view('admin_data_dosen.edit', compact('dosen', 'hal'));
    }

    public function update(Request $request, $nik)
    {
        $request->validate([
            'nama'    => 'required',
            'kontak'  => 'required',
            'email'   => 'required|email',
            'kelamin' => 'required',
        ]);

        $dosen = Dosen::findOrFail($nik);
        $dosen->nama = $request->nama;
        $dosen->kontak = $request->kontak;
        $dosen->email = $request->email;
        $dosen->kelamin = $request->kelamin;
        $dosen->save();

        return redirect()->route('admin.dosen.index')
            ->with('success', 'Data dosen berhasil diperbarui!');
    }

    public function destroy($nik)
    {
        $dosen = Dosen::find($nik);

        if ($dosen && !empty($dosen->img)) {
            $cleanPath = str_replace('../', '', $dosen->img);
            $oldPath = public_path($cleanPath);
            
            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }
        }

        if ($dosen) {
            $dosen->delete();
        }
        
        $user = User::where('username', $nik)->first();
        if ($user) {
            $user->delete();
        }

        return redirect()->route('admin.dosen.index')
            ->with('success', 'Data dosen dan fotonya berhasil dihapus');
    }
    
    public function update_foto(Request $request, $nik)
    {
        $request->validate([
            'file_foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);
        
        $dosen = Dosen::findOrFail($nik);
        
        if ($request->hasFile('file_foto')) {
            $file = $request->file('file_foto');
            $filename = time() . '_' . $file->getClientOriginalName();

            if (!empty($dosen->img)) {
                $cleanPath = str_replace('../', '', $dosen->img);
                $oldPath = public_path($cleanPath);
                
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $file->move(public_path('uploads/dosen'), $filename);

            $dosen->img = 'uploads/dosen/' . $filename;
            $dosen->save();
            
            return redirect()->route('admin.dosen.index')
                ->with('success', 'Foto dosen berhasil diperbarui');
        }
    }

    public function reset()
    {
        DB::beginTransaction();
        try {
            Dosen::query()->delete();
            User::where('peran','d')->delete();

            $folderFoto = public_path('uploads/dosen');
            if (File::exists($folderFoto)) {
                File::cleanDirectory($folderFoto);
            }

            DB::commit();
            return redirect()->route('admin.dosen.index')->with('success', 'Seluruh data dosen berhasil direset');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.dosen.index')->with('error', 'Gagal mereset data: ' . $e->getMessage());
        }
    }

    public function cetak_pdf()
    {
        $dosen= Dosen::all();
        //load html ke odf
        $pdf = Pdf::loadView('admin_data_dosen.cetak_pdf', compact('dosen'));
        $pdf->setPaper('A4', 'portrait');
        //render pdf
        return $pdf->stream('Data_Dosen.pdf');
    }

    public function export_excel()
    {
        $nama_file = 'Data_Dosen' . date('Y-m-d') . '.xlsx';
        return Excel::download(new DosenExport, $nama_file);
    }

    public function import_excel(Request $request)
    {
        $file = $request->file('file_excel');
        Excel::import(new DosenImport, $file);
        return redirect()->back()->with('success', 'Impor data berhasil');
    }
}
