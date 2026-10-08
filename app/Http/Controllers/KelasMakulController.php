<?php

namespace App\Http\Controllers;

use App\Imports\KelasMakulImport;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Perak;
use App\Models\Matkul;
use App\Models\Dosen;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Log;
use App\Models\Pertemuan;
use App\Models\DetailKelas;
use App\Models\Presensi;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class KelasMakulController extends Controller
{
    public function index(Request $request)
    {
        $periode = Perak::all();
        $matkul = Matkul::all();
        $dosen = Dosen::all();
        $jurusan = Jurusan::all();
        $kelas = [];

        if ($request->has('kode_akd') && $request->kode_akd != '') {
            $kelas = Kelas::with(['akademik','makul','dosen','jurusan'])
            ->where('kode_akd', $request->kode_akd)
            ->get();
        }
        return view('admin_data_kelas.index', compact(
            'periode',
            'matkul',
            'dosen',
            'jurusan',
            'kelas'
        ));
    }

    public function index_dosen(Request $request)
    {
        $periode = Perak::all();
        $matkul = Matkul::all();
        $dosen = Dosen::all();
        $jurusan = Jurusan::all();
        $kelas = [];

        if ($request->has('kode_akd') && $request->kode_akd != '') {
            $kelas = Kelas::with(['akademik','makul','dosen','jurusan'])
            ->where('kode_akd', $request->kode_akd)
            ->get();
        }
        return view('dosen_data_kelas.index', compact(
            'periode',
            'matkul',
            'dosen',
            'jurusan',
            'kelas'
        ));
    }

    public function store(Request $request)
    {
        $cek = Kelas::where('kode_akd', $request->kode_akd)
        ->where('kode_makul', $request->kode_makul)
        ->where('kode_jurusan', $request->kode_jurusan)
        ->where('nik', $request->nik)
        ->where('nama_kelas', $request->nama_kelas)
        ->first();

        if($cek) {
            return redirect()->back()->with('error', 'Kelas Sudah Ada!');
        }
        Kelas::create([
            'kode_akd' => $request->kode_akd,
            'kode_makul' => $request->kode_makul,
            'kode_jurusan' => $request->kode_jurusan,
            'nik' => $request->nik,
            'nama_kelas' => $request->nama_kelas,
        ]);
        return redirect()->back()->with('success', 'Berhasil Tambah Kelas!');
    }

    public function hapus($id)
    {
        Kelas::where('id', $id)->delete();
        return redirect()->back()->with('success','Kelas Berhasil Dihapus!');
    }
    
    public function update(Request $request, $id)
    {
        $cek = Kelas::where('kode_akd', $request->kode_Akd)
        ->where('kode_makul', $request->kode_makul)
        ->where('kode_jurusan', $request->kode_jurusan)
        ->where('nik', $request->nik)
        ->where('nama_kelas', $request->nama_kelas)
        ->where('id', '!=', $id)
        ->first();

        if($cek) {
            return redirect()->back()->with('error', 'Data Kelas Tidak Boleh Sama!');
        }
        Kelas::where('id',$id)->update([
            'kode_akd' => $request->kode_akd,
            'kode_makul' => $request->kode_makul,
            'kode_jurusan' => $request->kode_jurusan,
            'nik' => $request->nik,
            'nama_kelas' => $request->nama_kelas,
        ]);
        return redirect()->route('admin.kelas.index', ['kode_akd' => $request->kode_akd])
        ->with('success','Data Berhasil diedit');
    }

    public function edit($id){
        $kelas = Kelas::findOrFail($id);

        $periode = Perak::all();
        $makul = Matkul::all();
        $jurusan = Jurusan::all();
        $dosen = Dosen::all();

        $hal = 'data_kelas';
        return view('admin_data_kelas.edit', compact(
            'kelas',
            'hal',
            'periode',
            'makul',
            'jurusan',
            'dosen'
            ));
    }

    public function cetak_rekap($id)
    {
        //data kls dan relasi
        $kelas = Kelas::with(['dosen', 'makul', 'jurusan', 'akademik'])->findOrFail($id);
        //total pert
        $total_pertemuan = Pertemuan::where('id_kelas', $id)->count();
        if ($total_pertemuan == 0) {
            $total_pertemuan = 1; //cegah bagi 0
        }
        //data kls dan rlsi mhs
        $detail_kelas = DetailKelas::with('mahasiswa')->where('id', $id)->get();
        //array kosong buat nampung rekap
        $rekap_presensi = [];
        foreach ($detail_kelas as $index => $detail) {
            $nim = $detail->nim;

            //hitung jml hadir
            $jml_hadir = Presensi::where('nim', $nim)
            ->where('status_kehadiran', '2')
            ->whereHas('pertemuan', function($query) use ($id) {
                $query->where('id_kelas', $id);
            })
            ->count();

            //hitung %
            $persentase_hadir = ($jml_hadir / $total_pertemuan) * 100;
            $persentase_kontrak = $persentase_hadir * ($kelas->bobot_persen / 100);

            //susun data
            $rekap_presensi[] = [
                'no' => $index + 1,
                'nim' => $nim,
                'nama' => $detail->mahasiswa ? $detail->mahasiswa->nama : 'Tidak Ditemukan',
                'jml_hadir' => $jml_hadir,
                'persentase_hadir' => $persentase_hadir,
                'persentase_kontrak' => $persentase_kontrak
                ];
        }
        //lempar ke view
        $pdf = Pdf::loadView('admin_data_kelas.cetak_rekap_pdf', compact('kelas', 'total_pertemuan', 'rekap_presensi'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Rekap_presensi_' . $kelas->nama_kelas . '.pdf');
    }

    public function import_excel(Request $request)
    {
        $file = $request->file('file_excel');
        Excel::import(new KelasMakulImport, $file);
        return redirect()->back()->with('success', 'Impor data kelas beserta mahasiswa berhasil');
    }
}