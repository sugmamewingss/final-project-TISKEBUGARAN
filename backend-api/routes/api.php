<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\WorkoutLogController;

// Publik
Route::post('/auth/login', [AuthController::class, 'login']);

// Wajib Login (Token Valid)
Route::middleware('auth:api')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    
    // Semua yang login bisa lihat daftar gerakan
    Route::get('/exercises', [ExerciseController::class, 'index']);

    // KHUSUS ADMIN: Menambah gerakan baru
    Route::middleware('role:admin')->group(function () {
        Route::post('/exercises', [ExerciseController::class, 'store']);
    });

    // KHUSUS MEMBER: Mencatat log latihan
    Route::middleware('role:member')->group(function () {
        Route::post('/workouts', [WorkoutLogController::class, 'store']);
    });
});