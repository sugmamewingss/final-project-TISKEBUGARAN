<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Fungsi untuk memproses Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        // Jika email/password salah
        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email atau password tidak sesuai'
            ], 401);
        }

        // Jika berhasil login
        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'data' => [
                'user' => Auth::guard('api')->user(),
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]
        ]);
    }

    // Fungsi untuk melihat data user yang sedang login
    public function me()
    {
        return response()->json([
            'status' => 'success',
            'data' => Auth::guard('api')->user()
        ]);
    }

    // Fungsi untuk Logout (menghanguskan token)
    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil logout'
        ]);
    }
}