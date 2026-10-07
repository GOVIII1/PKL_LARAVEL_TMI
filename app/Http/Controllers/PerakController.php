<?php

namespace App\Http\Controllers;

use App\Models\Perak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PerakExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PerakImport;


class PerakController extends Controller
{
    public function index(){
        $perak = Perak::all();
        return view('admin_data_periode_akademik.index', compact('perak'));
    }

    public function store(Request $request){
    $kode_akd = $request->kode_akd;

    $cek = Perak::where('kode_akd', $kode_akd)->first();

    if($cek){
        return redirect()->back()->with('error', 'Data Sudah Ada');
    }else{
        Perak::create([
            'kode_akd' => $request->kode_akd,
            'semester' => $request->semester,
            'tahun' => $request->tahun,
            'is_active' => $request->is_active,
        ]);

        return redirect()->back()->with('success', 'Berhasil Tambah Data');
    }
    }

    public function edit($kode_akd){
    $perak = Perak::where('kode_akd',$kode_akd)->first();
    return view('admin_data_periode_akademik.edit', compact('perak'));
    }

    public function update(Request $request){
        Perak::where ('kode_akd', $request->kode_akd)->update([
        'semester'=>$request->semester,
        'tahun' =>$request->tahun,
        'is_active' =>$request->is_active,
    ]);
    return redirect()->route('admin.perak.index')->with('success', 'Berhasil diubah');
    }

    public function hapus($kode_akd){
        Perak::where ('kode_akd', $kode_akd)->delete();
        return redirect()->route('admin.perak.index')->with('success', 'Data Berhasil Dihapus');
    }    

    public function cetak_pdf()
    {
        $perak = Perak::all();
        $pdf = Pdf::loadView('admin_data_periode_akademik.cetak_pdf', compact('perak'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Data_Perak.pdf');
    }

    public function export_excel()
    {
        $nama_file = 'Data_Periode_Akademik' . date('Y-m-d') . '.xlsx';
        return Excel::download(new PerakExport, $nama_file);
    }

    public function import_excel(Request $request)
    {
        $file = $request->file('file_excel');
        Excel::import(new PerakImport, $file);
        return redirect()->back()->with('success','Impor Data Berhasil');
    }
}