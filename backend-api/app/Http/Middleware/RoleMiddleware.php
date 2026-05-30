<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Cek apakah user sudah login dan rolenya sesuai dengan yang diminta di Route
        if (!Auth::guard('api')->check() || Auth::guard('api')->user()->role !== $role) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak (403 Forbidden). Anda tidak memiliki izin.'
            ], 403);
        }

        return $next($request);
    }
}