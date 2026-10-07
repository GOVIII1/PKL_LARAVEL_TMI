<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertemuan;
use App\Models\Kelas;
use App\Models\DetailKelas;
use App\Models\Presensi;
use Barryvdh\DomPDF\Facade\Pdf;

class PertemuanController extends Controller
{
    public function index($id)
    {
        $kelas = Kelas::with(['akademik','dosen','jurusan','makul'])->findOrFail($id);
        $pertemuan = Pertemuan::where('id_kelas', $id)->get();
        return view('admin_data_kelas.pertemuan', compact('kelas', 'pertemuan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kelas' => 'required',
            'judul_pertemuan' => 'required',
            'tanggal' => 'required|date|after_or_equal:today',
        ], [
            'tanggal.after_or_equal' => 'Tanggal pertemuan minimal hari ini!'
        ]);

        $maxPertemuan = Pertemuan::where('id_kelas', $request->id_kelas)->max('pertemuan_ke');
        $pertemuanKe = $maxPertemuan ? $maxPertemuan + 1 : 1;

        $pertemuan = Pertemuan::create([
            'id_kelas' => $request->id_kelas,
            'tanggal' => $request->tanggal,
            'judul_pertemuan' => $request->judul_pertemuan,
            'status_presensi' => '0',
            'pertemuan_ke' => $pertemuanKe
        ]);

        $peserta = DetailKelas::where('id_klsmk', $request->id_kelas)->get();

        if ($peserta->count() > 0) {
            $dataPresensi = [];

            foreach ($peserta as $p) {
                $dataPresensi[] = [
                    'id_pertemuan' => $pertemuan->id,
                    'nim' => $p->nim,
                    'status_kehadiran' => '1'
                ];
            }
            Presensi::insert($dataPresensi);
    }
    return redirect()->back()->with('success', 'Pertemuan ke ' . $pertemuanKe . 'Berhasil dibuat');
    }

    public function update_bobot(Request $request)
    {
        $request->validate([
            'id_kelas' => 'required',
            'bobot_persen' => 'required|numeric|min:0|max:100'
        ]);

        $kelas =Kelas::findOrFail($request->id_kelas);

        $kelas->bobot_persen = $request->bobot_persen;
        $kelas->save();

        return redirect()->back()->with('success', 'Presentase kontrak berhasil diupdate menjadi ' . $request->bobot_persen . '%');
    }

public function cetak_pdf($id)
    {
        $kelas = Kelas::with(['akademik', 'dosen', 'jurusan', 'makul'])->findOrFail($id);

        $pertemuan = Pertemuan::with(['presensi.mahasiswa'])
            ->where('id_kelas', $id)
            ->orderBy('pertemuan_ke', 'ASC')
            ->get();

        $total_pertemuan = $pertemuan->count();

        $pdf = Pdf::loadView('admin_data_kelas.cetak_pertemuan_pdf', compact('kelas', 'pertemuan', 'total_pertemuan'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Laporan_Pertemuan_' . $kelas->nama_kelas . '.pdf');
    }
}