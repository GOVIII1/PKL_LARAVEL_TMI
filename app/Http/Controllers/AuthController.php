<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    //tampilkan halaman login
    public function showLogin()
    {
        //kalau udah login redirect ke home sesuai peran
        if (session()->has('user')) {
            return $this->redirectByPeran(session('user')['peran']);
        }

        return view('login');
    }

    //cek username password doang via ajax sebelum modal pin muncul
    public function checkCredentials(Request $request)
    {
        $username = trim($request->input('username'));
        $rawPassword = trim($request->input('password'));
        $passwordSha1 = sha1($rawPassword);

        $exists = DB::table('user')
            ->where('username', $username)
            ->where(function ($query) use ($passwordSha1, $rawPassword) {
                $query->where('password', $passwordSha1)
                      ->orWhere('password', $rawPassword);
            })
            ->exists();

        if (!$exists) {
            return response()->json([
                'valid'   => false,
                'message' => 'Username atau Password salah!'
            ]);
        }

        return response()->json(['valid' => true]);
    }

    //proses login lengkap username password pin
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'pin'      => 'required',
        ]);

        $username = trim($request->input('username'));
        $rawPassword = trim($request->input('password'));
        $passwordSha1 = sha1($rawPassword);
        $pin      = trim($request->input('pin'));
        $pinSha1  = sha1($pin);

        //query ke tabel user pake kolom password
        $user = DB::table('user')
            ->where('username', $username)
            ->where(function ($query) use ($passwordSha1, $rawPassword) {
                $query->where('password', $passwordSha1)
                      ->orWhere('password', $rawPassword);
            })
            ->where(function ($query) use ($pin, $pinSha1) {
                $query->where('pin', $pin)
                      ->orWhere('pin', $pinSha1);
            })
            ->first();

        if (!$user) {
            return back()->with('error', 'Username, Password, atau PIN salah!');
        }

        //simpan data user ke session
        session([
            'user' => [
                'id'       => $user->id,
                'username' => $user->username,
                'nama'     => $user->nama ?? $user->username,
                'peran'    => $user->peran,
            ]
        ]);

        return $this->redirectByPeran($user->peran);
    }

    //logout hapus session redirect ke login
    public function logout()
    {
        session()->forget('user');
        return redirect('/');
    }

    //redirect berdasarkan peran m=mahasiswa a=admin selain itu dosen
    private function redirectByPeran(string $peran)
    {
        $peranLower = strtolower(trim($peran));

        if ($peranLower === 'm') {
            return redirect()->route('home.mahasiswa');
        } elseif ($peranLower === 'a') {
            return redirect()->route('home.admin');
        } else {
            return redirect()->route('home.dosen');
        }
    }
}
