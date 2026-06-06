<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GymExerciseSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('exercises')->truncate();
        Schema::enableForeignKeyConstraints();

        $exercises = [
            [
                'name' => 'Bench Press',
                'category' => 'Chest',
                'description' => 'Latihan utama untuk membangun otot dada secara keseluruhan menggunakan barbell.',
            ],
            [
                'name' => 'Barbell Squat',
                'category' => 'Legs',
                'description' => 'Latihan compound terbaik untuk melatih otot tubuh bagian bawah, terutama paha depan dan bokong.',
            ],
            [
                'name' => 'Bicep Curl',
                'category' => 'Arms',
                'description' => 'Latihan isolasi otot bicep menggunakan dumbbell atau barbell untuk memperbesar ukuran lengan depan.',
            ],
            [
                'name' => 'Deadlift',
                'category' => 'Back & Legs',
                'description' => 'Latihan seluruh tubuh yang berfokus pada kekuatan otot punggung, paha belakang, dan core/perut.',
            ],
            [
                'name' => 'Pull Up',
                'category' => 'Back',
                'description' => 'Latihan beban tubuh (bodyweight) terbaik untuk memperlebar dan memperkuat otot punggung atas.',
            ],
            [
                'name' => 'Overhead Press',
                'category' => 'Shoulders',
                'description' => 'Latihan mendorong beban ke atas kepala untuk melatih kekuatan dan ukuran otot bahu secara keseluruhan.',
            ],
            [
                'name' => 'Tricep Extension',
                'category' => 'Arms',
                'description' => 'Latihan isolasi yang sangat efektif untuk membesarkan otot tricep di bagian belakang lengan.',
            ],
            [
                'name' => 'Lunges',
                'category' => 'Legs',
                'description' => 'Latihan unilateral untuk melatih keseimbangan kaki dan memperkuat paha depan serta bokong.',
            ],
            [
                'name' => 'Leg Press',
                'category' => 'Legs',
                'description' => 'Latihan menggunakan mesin untuk fokus pada paha depan (quadriceps) tanpa memberikan tekanan besar pada punggung bawah.',
            ],
            [
                'name' => 'Lat Pulldown',
                'category' => 'Back',
                'description' => 'Latihan tarikan menggunakan mesin kabel yang menargetkan otot sayap punggung (latissimus dorsi).',
            ],
            [
                'name' => 'Incline Dumbbell Press',
                'category' => 'Chest',
                'description' => 'Variasi bench press dengan sudut bangku miring ke atas untuk menargetkan pembentukan otot dada bagian atas.',
            ],
            [
                'name' => 'Dumbbell Fly',
                'category' => 'Chest',
                'description' => 'Latihan isolasi dengan gerakan membuka lengan untuk meregangkan dan membentuk otot dada bagian tengah.',
            ],
            [
                'name' => 'Lateral Raise',
                'category' => 'Shoulders',
                'description' => 'Latihan elevasi samping untuk menargetkan otot bahu bagian samping (lateral deltoid) agar bahu terlihat lebih lebar.',
            ],
            [
                'name' => 'Front Raise',
                'category' => 'Shoulders',
                'description' => 'Latihan mengangkat beban ke depan tubuh menggunakan dumbbell untuk melatih otot bahu bagian depan (anterior deltoid).',
            ],
            [
                'name' => 'Face Pull',
                'category' => 'Shoulders & Back',
                'description' => 'Latihan menggunakan mesin kabel untuk memperbaiki postur tubuh dan melatih otot bahu bagian belakang.',
            ],
            [
                'name' => 'Calf Raise',
                'category' => 'Legs',
                'description' => 'Latihan isolasi jinjit yang difokuskan untuk memperbesar dan memperkuat otot betis kaki.',
            ],
            [
                'name' => 'Hammer Curl',
                'category' => 'Arms',
                'description' => 'Variasi bicep curl dengan genggaman netral untuk melatih otot brachialis dan memperkuat lengan bawah.',
            ],
            [
                'name' => 'Dips',
                'category' => 'Chest & Arms',
                'description' => 'Latihan menahan dan mendorong beban tubuh untuk melatih otot dada bagian bawah dan otot tricep secara bersamaan.',
            ],
            [
                'name' => 'Romanian Deadlift',
                'category' => 'Legs & Back',
                'description' => 'Variasi deadlift yang menargetkan otot paha belakang (hamstrings) dan otot bokong dengan posisi kaki sedikit menekuk.',
            ],
            [
                'name' => 'Crunches',
                'category' => 'Core',
                'description' => 'Latihan dasar yang sangat populer untuk mengisolasi dan melatih otot perut depan (rectus abdominis).',
            ],
        ];

        $now = now();
        foreach ($exercises as &$exercise) {
            $exercise['created_at'] = $now;
            $exercise['updated_at'] = $now;
        }

        DB::table('exercises')->insert($exercises);
    }
}
