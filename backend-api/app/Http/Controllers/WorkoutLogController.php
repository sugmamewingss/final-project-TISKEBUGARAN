<?php

namespace App\Http\Controllers;

use App\Models\WorkoutLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class WorkoutLogController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi Input 
        $request->validate([
            'exercise_id' => 'required|exists:exercises,id',
            'date' => 'required|date',
            'sets' => 'required|integer',
            'reps' => 'required|integer',
            'weight_kg' => 'required|numeric'
        ]);

        // 2. Integrasi API Pihak Ketiga: Wger Fitness API
        $wgerApiUrl = 'https://wger.de/api/v2/exercise/?language=2&limit=20';
        $wgerResponse = Http::get($wgerApiUrl);
        
        $recommendation = 'Lakukan peregangan ringan.'; 
        
        // JARING PENGAMAN: Pastikan response sukses DAN memiliki key 'results'
        if ($wgerResponse->successful() && isset($wgerResponse->json()['results'])) {
            $exercises = $wgerResponse->json()['results'];
            
            if (!empty($exercises)) {
                $randomExercise = $exercises[array_rand($exercises)];
                
                // JARING PENGAMAN 2: Gunakan '??' jika key 'name' tidak dikirim oleh Wger
                $exerciseName = $randomExercise['name'] ?? $randomExercise['name_original'] ?? 'Latihan Otot Acak';
                
                $recommendation = 'Coba gerakan ini selanjutnya: ' . $exerciseName;
            }
        }

        // 3. Simpan Transaksi 
        $log = WorkoutLog::create([
            'user_id' => Auth::guard('api')->id(),
            'exercise_id' => $request->exercise_id,
            'date' => $request->date,
            'sets' => $request->sets,
            'reps' => $request->reps,
            'weight' => $request->weight_kg
        ]);

        // 4. Response JSON
        return response()->json([
            'status' => 'success',
            'message' => 'Sesi latihan berhasil dicatat',
            'data' => [
                'log_id' => $log->id,
                'volume_load_kg' => $request->sets * $request->reps * $request->weight_kg,
                'wger_recommendation' => $recommendation
            ]
        ], 201);
    }
}