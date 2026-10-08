<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertemuan;
use App\Models\Kelas;
use App\Models\Presensi;

class PresensiController extends Controller
{
    public function index($id_pertemuan)
    {
        $pertemuan = Pertemuan::findOrFail($id_pertemuan);
        $kelas = Kelas::with(['dosen', 'makul', 'jurusan'])->findOrFail($pertemuan->id_kelas);

        return view('admin_data_kelas.presensi', compact('pertemuan', 'kelas'));
    }

    public function index_dosen($id_pertemuan)
    {
        $pertemuan = Pertemuan::findOrFail($id_pertemuan);
        $kelas = Kelas::with(['dosen', 'makul', 'jurusan'])->findOrFail($pertemuan->id_kelas);

        return view('dosen_data_kelas.presensi', compact('pertemuan', 'kelas'));
    }

    public function tabel($id_pertemuan)
    {
        $presensi = Presensi::with('mahasiswa')->where('id_pertemuan', $id_pertemuan)->get();

        return view('admin_data_kelas.tabel_kehadiran', compact('presensi'));
    }

    public function tabel_dosen($id_pertemuan)
    {
        $presensi = Presensi::with('mahasiswa')->where('id_pertemuan', $id_pertemuan)->get();

        return view('admin_data_kelas.tabel_kehadiran', compact('presensi'));
    }

    public function update_status(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'status_kehadiran' => 'required'
        ]);

        $presensi = Presensi::findOrFail($request->id);

        $presensi->status_kehadiran = $request->status_kehadiran;
        $presensi->save();

        return redirect()->back()->with('success', 'Status kehadiran berhasil diubah!');
    }

    public function buka_tutup($id, $aksi)
    {
        $pertemuan = Pertemuan::findOrFail($id);

        if ($aksi == 'buka') {
            $pertemuan->status_presensi = '1';
        } elseif ($aksi == 'tutup') {
            $pertemuan->status_presensi = '0';
        }
        $pertemuan->save();
        return redirect()->back();
    }

    public function proses_scan($id_pertemuan)
    {
        // Mengambil data user dari session
        $userSession = session('user');
        $nim = $userSession['username']; 

        //validasi status pertemuan
        $pertemuan = Pertemuan::findOrFail($id_pertemuan);
        if ($pertemuan->status_presensi == 0) {
            return redirect()->route('mahasiswa.presensi')->with('error', 'Presensi telah ditutup!');
        }

        //mengambil data presensi berdasarkan pertemuan dan nim mahasiswa
        $presensi = Presensi::where('id_pertemuan', $id_pertemuan)
                            ->where('nim', $nim)
                            ->first();

        //validasi jika data presensi tidak ditemukan
        if (!$presensi) {
             return redirect()->route('mahasiswa.presensi')->with('error', 'Data Anda tidak ditemukan di kelas ini!');
        }

        //validasi jika mahasiswa sudah melakukan presensi
        if ($presensi->status_kehadiran == '2') {
            return redirect()->route('mahasiswa.presensi')->with('warning', 'Anda Telah Melakukan Presensi pada pertemuan ini!');
        }

        //update status kehadiran
        $presensi->status_kehadiran = '2';
        $presensi->save();

        return redirect()->route('mahasiswa.presensi')->with('success', 'Berhasil Melakukan Absensi!');
    }
}
