<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){

       $users = User::all();

        return view('admin.users.index', compact('users'));
    }
    public function destroy($id){
    $userTarget = tbl_pengguna::findOrFail($id);
    $penggunaLogin = session('username');

    if ($userTarget->username == $penggunaLogin) {
        return back()->with('error', 'Lu nggak bisa hapus akun lu sendiri bro!');
    }

    $jumlahAdmin = tbl_pengguna::where('peran', 'A')->count();
    if ($userTarget->peran == 'A' && $jumlahAdmin <= 1) {
        return back()->with('error', 'Gagal! Ini akun Admin satu-satunya yang tersisa di database.');
    }

    $userTarget->delete();

    return back()->with('success', 'Data Pengguna ' . $userTarget->username . ' Berhasil Dihapus');
    }

    public function store(Request $request){
    $cekUser = tbl_pengguna::where('username', $request->username)->first();

    if ($cekUser) {
        return back()->with('error', 'Username Sudah Terdaftar di Database!');
    }

    tbl_pengguna::create([
        'username' => trim($request->username),
        'nama'     => trim($request->nama),
        'peran'    => trim($request->peran),
        'password' => sha1($request->username),
        'pin'      => sha1('1234'),
    ]);
    return back()->with('success', 'Data Berhasil Disimpan');
    }
}
