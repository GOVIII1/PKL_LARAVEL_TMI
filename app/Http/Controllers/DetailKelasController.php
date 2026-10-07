<?php

namespace App\Http\Controllers;

use App\Models\DetailKelas;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Exports\DetailKelasExport;
use Maatwebsite\Excel\Facades\Excel;

class DetailKelasController extends Controller
{
    public function index($id_klsmk)
    {
        $kelas = Kelas::with(['akademik', 'dosen', 'jurusan', 'makul'])->findOrFail($id_klsmk);

        $detail = DetailKelas::with('mahasiswa')->where('id_klsmk', $id_klsmk)->get();

        $mahasiswa = Mahasiswa::all();

        return view('admin_detail_kelas.index', compact('kelas', 'detail', 'mahasiswa'));
    }

    public function store(Request $request)
    {
        //validasi
        $request->validate([
            'id_klsmk' => 'required',
            'nim' => 'required',
        ]);
        //cek
        $cek = DetailKelas::where('id_klsmk', $request->id_klsmk)
        ->where('nim', $request->nim)
        ->first();
        if ($cek) {
            return redirect()->back()->with('error','Mahasiswa Sudah terdaftar di Kelas!');
        }
        //simpan
        DetailKelas::create([
            'id_klsmk' => $request->id_klsmk,
            'nim' => $request->nim,
        ]);
        return redirect()->back()->with('success', 'Berhasil menambahkan mahasiswa ke kelas!');
    }

    public function destroy($id)
    {
        $detail = DetailKelas::findOrFail($id);
        $detail->delete();
        return redirect()->back()->with('success', 'Data mahasiswa berhasil dihapus dari kelas!');
    }

    public function export_excel()
    {
        $nama_file = 'Data_Detal_Kelas' . date('Y-m-d') . '.xlsx';
        return Excel::download(new DetailKelasExport, $nama_file);
    }
}

