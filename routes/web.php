<?php

use App\Http\Controllers\PresensiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MatkulController;
use App\Http\Controllers\PerakController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasMakulController;
use App\Http\Controllers\DetailKelasController;
use App\Http\Controllers\PertemuanController;

//login
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/check-credentials', [AuthController::class, 'checkCredentials'])->name('check.credentials');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


//cek auth
Route::middleware('check.auth')->group(function () {

    //role admin
    Route::middleware('check.role:a')->group(function () {
        Route::get('/home_admin', [AdminController::class, 'index'])->name('home.admin');
        
        //data administrator
        Route::get('/admin_data_administrator', [AdminController::class, 'dataAdministrator'])->name('admin.data_administrator');
        Route::post('/admin_data_administrator/tambah', [AdminController::class, 'storeUser'])->name('admin.user.store');
        Route::get('/admin_data_administrator/edit/{id}', [AdminController::class, 'editUser'])->name('admin.user.edit');
        Route::put('/admin_data_administrator/update/{id}', [AdminController::class, 'updateUser'])->name('admin.user.update');
        Route::delete('/admin_data_administrator/hapus/{id}', [AdminController::class, 'destroyUser'])->name('admin.user.destroy');
        
        //data mahasiswa
        Route::get('/admin_data_mahasiswa', [MahasiswaController::class, 'index'])->name('admin.mahasiswa.index');
        Route::post('/admin_data_mahasiswa/tambah', [MahasiswaController::class, 'store'])->name('admin.mahasiswa.store');
        Route::get('/admin_data_mahasiswa/edit/{nim}', [MahasiswaController::class, 'edit'])->name('admin.mahasiswa.edit');
        Route::put('/admin_data_mahasiswa/update/{nim}', [MahasiswaController::class, 'update'])->name('admin.mahasiswa.update');
        Route::get('/admin_data_mahasiswa/hapus/{nim}', [MahasiswaController::class, 'destroy'])->name('admin.mahasiswa.destroy');
        Route::post('/admin_data_mahasiswa/update_foto/{nim}', [MahasiswaController::class, 'update_foto'])->name('admin.mahasiswa.update_foto');
        Route::post('/admin_data_mahasiswa/reset', [MahasiswaController::class, 'reset'])->name('admin.mahasiswa.reset');
        Route::get('/admin_data_mahasiswa/cetak_pdf', [MahasiswaController::class, 'cetak_pdf'])->name('admin.mahasiswa.cetak_pdf');
        Route::get('/admin_data_mahasiswa/export_excel', [MahasiswaController::class, 'export_excel'])->name('admin.mahasiswa.export_excel');
        Route::post('/admin_data_mahasiswa/impor_excel', [MahasiswaController::class, 'import_excel'])->name('admin.mahasiswa.impor_excel');

        //data dosen
        Route::get('/admin_data_dosen', [DosenController::class, 'index'])->name('admin.dosen.index');
        Route::post('/admin_data_dosen/tambah', [DosenController::class, 'store'])->name('admin.dosen.store');
        Route::get('/admin_data_dosen/edit/{nik}', [DosenController::class, 'edit'])->name('admin.dosen.edit');
        Route::put('/admin_data_dosen/update/{nik}', [DosenController::class, 'update'])->name('admin.dosen.update');
        Route::get('/admin_data_dosen/hapus/{nik}', [DosenController::class, 'destroy'])->name('admin.dosen.destroy');
        Route::post('/admin_data_dosen/update_foto/{nik}', [DosenController::class, 'update_foto'])->name('admin.dosen.update_foto');
        Route::post('/admin_data_dosen/reset', [DosenController::class, 'reset'])->name('admin.dosen.reset');
        Route::get('/admin_data_dosen/cetak_pdf', [DosenController::class, 'cetak_pdf'])->name('admin.dosen.cetak_pdf');
        Route::get('/admin_data_dosen/export_excel', [DosenController::class, 'export_excel'])->name('admin.dosen.export_excel');
        Route::post('/admin_data_dosen/impor_excel', [DosenController::class, 'import_excel'])->name('admin.dosen.impor_excel');

        //data matkul
        Route::get('/admin_data_matkul', [MatkulController::class, 'index'])->name('admin.matkul.index');
        Route::post('/admin_data_matkul/tambah', [MatkulController::class, 'store'])->name('admin.matkul.store');
        Route::get('/admin_data_matkul/edit/{kode_makul}', [MatkulController::class, 'edit'])->name('admin.matkul.edit');
        Route::put('/admin_data_matkul/update', [MatkulController::class, 'update'])->name('admin.makul.update');
        Route::get('/admin_data_matkul/hapus/{kode_makul}', [MatkulController::class, 'hapus'])->name('admin.matkul.hapus');
        Route::get('/admin_data_matkul/cetak_pdf', [MatkulController::class, 'cetak_pdf'])->name('admin.matkul.cetak_pdf');
        Route::get('/admin_data_matkul/export_excel', [MatkulController::class, 'export_excel'])->name('admin.matkul.export_excel');
        Route::post('/admin_data_matkul/impor_excel', [MatkulController::class, 'import_excel'])->name('admin.matkul.impor_excel');

        //data perak
        Route::get('/admin_data_perak', [PerakController::class, 'index'])->name('admin.perak.index');
        Route::post('/admin_data_perak/tambah', [PerakController::class, 'store'])->name('admin.perak.store');
        Route::get('/admin_data_perak/edit/{kode_akd}', [PerakController::class, 'edit'])->name('admin.perak.edit');
        Route::put('/admin_data_perak/update', [PerakController::class, 'update'])->name('admin.perak.update');
        Route::get('/admin_data_perak/hapus/{kode_akd}', [PerakController::class, 'hapus'])->name('admin.perak.hapus');
        Route::get('/admin_data_perak/cetak_pdf', [PerakController::class, 'cetak_pdf'])->name('admin.perak.cetak_pdf');
        Route::get('/admin_data_perak/export_excel', [PerakController::class, 'export_excel'])->name('admin.perak.export_excel');
        Route::post('/admin_data_perak/import_excel', [PerakController::class, 'import_excel'])->name('admin.perak.import_excel');

        //data jurusan
        Route::get('/admin_data_jurusan', [JurusanController::class, 'index'])->name('admin.jurusan.index');
        Route::post('/admin_data_jurusan/tambah', [JurusanController::class, 'store'])->name('admin.jurusan.store');
        Route::get('/admin_data_jurusan/edit/{kode_jurusan}', [JurusanController::class, 'edit'])->name('admin.jurusan.edit');
        Route::put('/admin_data_jurusan/update/{kode_jurusan}', [JurusanController::class, 'update'])->name('admin.jurusan.update');
        Route::get('/admin_data_jurusan/hapus/{kode_jurusan}', [JurusanController::class, 'hapus'])->name('admin.jurusan.hapus');
        Route::get('/admin_data_jurusan/cetak_pdf', [JurusanController::class, 'cetak_pdf'])->name('admin.jurusan.cetak_pdf');
        Route::get('/admin_data_jurusan/export_excel', [JurusanController::class, 'export_excel'])->name('admin.jurusan.export_excel');
        Route::post('/admin_data_jurusan/import_excel', [JurusanController::class, 'import_excel'])->name('admin.jurusan.import_excel');

        //data Kelas
        Route::get('/admin_data_kelas', [KelasMakulController::class, 'index'])->name('admin.kelas.index');
        Route::post('/admin_data_kelas/tambah', [KelasMakulController::class, 'store'])->name('admin.kelas.store');
        Route::get('/admin_data_kelas/edit/{id}', [KelasMakulController::class, 'edit'])->name('admin.kelas.edit');
        Route::put('/admin_data_kelas/update/{id}', [KelasMakulController::class, 'update'])->name('admin.kelas.update');
        Route::get('/admin_data_kelas/hapus/{id}', [KelasMakulController::class, 'hapus'])->name('admin.kelas.hapus');
        Route::get('/admin_data_kelas/cetak_rekap/{id}', [KelasMakulController::class, 'cetak_rekap'])->name('admin.kelas.cetak_rekap');
        Route::post('/admin_data_kelas/import_excel', [KelasMakulController::class, 'import_excel'])->name('admin.kelas.import_excel');
        
        //detail Kelas
        Route::get('/admin_detail_kelas/export_excel', [DetailKelasController::class, 'export_excel'])->name('admin.detail.kelas.export_excel');
        Route::get('/admin_detail_kelas/{id_klsmk}', [DetailKelasController::class, 'index'])->name('admin.detail.kelas.index');
        Route::post('/admin_detail_kelas/store', [DetailKelasController::class, 'store'])->name('admin.detail.kelas.store');
        Route::get('/admin_detail_kelas/hapus/{id}', [DetailKelasController::class, 'destroy'])->name('admin.detail.kelas.hapus');
        Route::post('/admin_detail_kelas/import_excel', [DetailKelasController::class, 'import_excel'])->name('admin.detail.kelas.import_excel');

        //pertemuan
        Route::get('/admin_kelas_matkul/pertemuan/{id}', [PertemuanController::class, 'index'])->name('admin.pertemuan.index');
        Route::post('/admin_kelas_matkul/pertemuan/store', [PertemuanController::class,'store'])->name('admin.pertemuan.store');
        Route::post('/admin_kelas_matkul/pertemuan/update_bobot',[PertemuanController::class,'update_bobot'])->name('admin.pertemuan.updatebobot');
        Route::get('/admin_kelas_matkul/pertemuan/cetak/{id}', [PertemuanController::class, 'cetak_pdf'])->name('admin.pertemuan.cetak_pertemuan');
        
        //presensi
        Route::get('/admin_kelas_matkul/presensi/{id_pertemuan}', [PresensiController::class, 'index'])->name('admin.presensi.index');
        Route::post('/admin_kelas_matkul/presensi/update_status', [PresensiController::class, 'update_status'])->name('admin.presensi.update.status');
        Route::get('/admin_kelas_matkul/presensi/status/{id}/{aksi}', [PresensiController::class, 'buka_tutup'])->name('admin.presensi.buka.tutup');
        
        //load tabel ajax
        Route::get('/admin_kelas_matkul/presensi/tabel/{id_pertemuan}', [PresensiController::class, 'tabel'])->name('admin.presensi.tabel');
        
        //ganti pw
        Route::get('/admin_ganti_password', [AdminController::class, 'ganti_password'])->name('admin.ganti.password.index');
        Route::post('/admin_ganti_password/proses', [AdminController::class, 'proses_ganti_password'])->name('admin.password.proses');
        
    });

    //role dosen
    Route::middleware('check.role:d')->group(function () {
        Route::get('/home_dosen', function () {
            return view('home_dosen.index');
        })->name('home.dosen');

        //ganti pw
        Route::get('/dosen_ganti_password', [DosenController::class, 'ganti_password'])->name('dosen.ganti.password.index');
        Route::post('/dosen_ganti_password/proses', [DosenController::class, 'proses_ganti_password'])->name('dosen.password.proses');

        //data Kelas
        Route::get('/dosen_data_kelas', [KelasMakulController::class, 'index_dosen'])->name('dosen.kelas.index');
        Route::get('/dosen_data_kelas/cetak_rekap/{id}', [KelasMakulController::class, 'cetak_rekap'])->name('dosen.kelas.cetak_rekap');
        Route::post('/dosen_data_kelas/import_excel', [KelasMakulController::class, 'import_excel'])->name('dosen.kelas.import_excel');

        //detail kelas
        Route::get('/dosen_detail_kelas/{id_klsmk}', [DetailKelasController::class, 'index_dosen'])->name('dosen.detail.kelas.index');

        //pertemuan
        Route::get('/dosen_kelas_matkul/pertemuan/{id}', [PertemuanController::class, 'index_dosen'])->name('dosen.pertemuan.index');
        Route::post('/dosen_kelas_matkul/pertemuan/store', [PertemuanController::class,'store'])->name('dosen.pertemuan.store');
        Route::post('/dosen_kelas_matkul/pertemuan/update_bobot',[PertemuanController::class,'update_bobot'])->name('dosen.pertemuan.updatebobot');
        Route::get('/dosen_kelas_matkul/pertemuan/cetak/{id}', [PertemuanController::class, 'cetak_pdf'])->name('dosen.pertemuan.cetak_pertemuan');

        //presensi
        Route::get('/dosen_kelas_matkul/presensi/{id_pertemuan}', [PresensiController::class, 'index_dosen'])->name('dosen.presensi.index');
        Route::get('/dosen_kelas_matkul/presensi/status/{id}/{aksi}', [PresensiController::class, 'buka_tutup'])->name('dosen.presensi.buka.tutup');
        Route::post('/dosen_kelas_matkul/presensi/update_status', [PresensiController::class, 'update_status'])->name('dosen.presensi.update.status');

        //load tabel ajax
        Route::get('/dosen_kelas_matkul/presensi/tabel/{id_pertemuan}', [PresensiController::class, 'tabel_dosen'])->name('dosen.presensi.tabel');
    });

    //role mahasiswa
    Route::middleware('check.role:m')->group(function () {
        Route::get('/home_mahasiswa', function () {
            return view('home_mahasiswa.index');
        })->name('home.mahasiswa');
        
        Route::get('/mahasiswa_presensi', function () {
            return view('mahasiswa_presensi.index');
        })->name('mahasiswa.presensi');
        Route::get('/mahasiswa_presensi/proses/{id_pertemuan}', [PresensiController::class, 'proses_scan'])->name('mahasiswa.presensi.proses');
        //pw
        Route::get('/mahasiswa_ganti_password', [MahasiswaController::class, 'ganti_password'])->name('mahasiswa.ganti.password.index');
        Route::post('/mahasiswa_ganti_password/proses', [MahasiswaController::class, 'proses_ganti_password'])->name('mahasiswa.password.proses');
    });

});