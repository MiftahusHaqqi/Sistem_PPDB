<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Sekarang Auth::check() tidak akan error lagi
        if (!Auth::check() || Auth::user()->role !== $role) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return $next($request);
    }
}