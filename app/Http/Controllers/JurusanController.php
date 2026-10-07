<?php

namespace App\Http\Controllers;

use App\Imports\JurusanImport;
use Illuminate\Http\Request;
use App\Models\Jurusan;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\JurusanExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;


class JurusanController extends Controller
{
    public function index(){
        $jurusan = Jurusan::all();
        return view('admin_data_jurusan.index', compact('jurusan'));
    }

    public function store(Request $request){
        $kode_jurusan = $request->kode_jurusan;
        $cek_jurusan = Jurusan::where('kode_jurusan', $kode_jurusan)->first();
        if($cek_jurusan){
            return redirect()->back()->with('error', 'Jurusan Sudah Ada!');
        }else{
            Jurusan::create([
                'kode_jurusan' => $request->kode_jurusan,
                'nama_jurusan' => $request->nama_jurusan,
            ]);
            return redirect()->back()->with('success', 'Berhasil Tambah Data Jurusan');
        }
    }

    public function edit($kode_jurusan){
        $jurusan = Jurusan::where('kode_jurusan',$kode_jurusan)->first();
        return view('admin_data_jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request){
        Jurusan::where ('kode_jurusan', $request->kode_jurusan)->update([
            'kode_jurusan'=>$request->kode_jurusan,
            'nama_jurusan'=>$request->nama_jurusan,
        ]);
        return redirect()->route('admin.jurusan.index')->with('success','Berhasil diubah');
    }

    public function hapus($kode_jurusan){
        Jurusan::where ('kode_jurusan', $kode_jurusan)->delete();
        return redirect()->route('admin.jurusan.index')->with('success', 'Data Berhasil Dihapus');
    }

    public function cetak_pdf()
    {
        $jurusan = Jurusan::all();
        $pdf = Pdf::loadView('admin_data_jurusan.cetak_pdf', compact('jurusan'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Data_Jurusan.pdf');
    }

    public function export_excel()
    {
        $nama_file = 'Data_Jurusan' . date('Y-m-d') . '.xlsx';
        return Excel::download(new JurusanExport, $nama_file);
    }

    public function import_excel(Request $request)
    {
        $file = $request->file('file_excel');
        Excel::import(new JurusanImport,$file);
        return redirect()->back()->with('success', 'Import data jurusan berhasil');
    }
}