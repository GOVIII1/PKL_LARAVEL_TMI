<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = session('user');

        $peranUser = strtolower(trim($user['peran']));
        $peranDiizinkan = strtolower(trim($role));

        if ($peranUser !== $peranDiizinkan) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki izin untuk membuka halaman ini.');
        }
        return $next($request);
    }
}