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
        $validated = $request->validate([
            'name' => 'required|string',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // max 2MB
        ]);

        // Simpan file gambar (jika ada) ke storage/app/public/exercises
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('exercises', 'public');
        }

        $exercise = Exercise::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Gerakan berhasil ditambahkan',
            'data' => $exercise
        ], 201);
    }
}