<?php

namespace App\Http\Controllers;

use App\Models\Matkul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\MatkulExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MatkulImport;

class MatkulController extends Controller
{
    public function index(){
        $matkul = Matkul::all();
        return view('admin_data_matkul.index', compact('matkul'));
    }

    public function store(Request $request){
        $kode_makul = $request->kode_makul;

        $cek = Matkul::where('kode_makul', $kode_makul)->first();

        if($cek){
            return redirect()->back()->with('error', 'Data Sudah Ada');
        }else{
            Matkul::create([
                'kode_makul' => $request->kode_makul,
                'nama_makul' => $request->nama_makul,
                'jml_sks' => $request->jml_sks,
                'jml_cpmk' => $request->jml_cpmk,
            ]);

            return redirect()->back()->with('success', 'Berhasil Tambah Data');
        }
    }

    public function edit($kode_makul){
        $makul = Matkul::where('kode_makul',$kode_makul)->first();
        return view('admin_data_matkul.edit', compact('makul'));
    }

    public function update(Request $request){
        Matkul::where ('kode_makul', $request->kode_makul)->update([
            'nama_makul'=>$request->nama_makul,
            'jml_sks' =>$request->jml_sks,
            'jml_cpmk' =>$request->jml_cpmk,
        ]);
        return redirect()->route('admin.matkul.index')->with('success', 'Berhasil diubah');
    }

    public function hapus($kode_makul){
        Matkul::where ('kode_makul', $kode_makul)->delete();

        return redirect()->route('admin.matkul.index')->with('success', 'Data Berhasil dihapus');
    }

    public function cetak_pdf()
    {
        $matkul = Matkul::all();
        $pdf = Pdf::loadView('admin_data_matkul.cetak_pdf', compact('matkul'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Data_Matkul.pdf');
    }

    public function export_excel()
    {
        $nama_file = 'Data_matkul_' . date('Y-m-d') . '.xlsx';
        return Excel::download(new MatkulExport, $nama_file);
    }

    public function import_excel(Request $request)
    {
        $file = $request->file('file_excel');
        Excel::import(new MatkulImport, $file);
        return redirect()->back()->with('success', 'Impor data berhasil');
    }
}