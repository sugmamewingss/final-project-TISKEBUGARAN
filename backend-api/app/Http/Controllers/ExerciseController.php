<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    // Bisa diakses semua user (untuk melihat daftar gerakan)
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => Exercise::all()
        ]);
    }

    // Khusus Admin
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'category' => 'required|string',
            'description' => 'nullable|string'
        ]);

        $exercise = Exercise::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Gerakan berhasil ditambahkan',
            'data' => $exercise
        ], 201);
    }
}