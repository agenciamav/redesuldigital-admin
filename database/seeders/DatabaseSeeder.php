<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create a quiz
        $quiz = \App\Models\Quiz::create([
            'status' => 'active',
        ]);


        $quizSections = json_decode(file_get_contents(__DIR__ . '/questions.json'), true);

        foreach ($quizSections['questions'] as $section) {
            if (Arr::exists($section, 'questions')) {
                foreach ($section['questions'] as $index => $question) {
                    // create section if not exists
                    $sectionModel = \App\Models\Section::firstOrCreate(
                        ['code' => $section['id'], 'quiz_id' => $quiz->id],
                        [
                            'title' => $section['title'],
                            'description' => $section['description'] ?? null,
                        ]
                    );

                    // create question
                    $sectionModel->questions()->create([
                        'quiz_id' => $quiz->id,
                        'code' => $index,
                        'type' =>  $question['type'] ?? '',
                        'options' => $question['options'] ?? null,
                        'text' => $question['text'] ?? '',
                        'required' => $question['required'] ?? false,
                    ]);
                }
            }
        }

        // Create a user
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => env('ADMIN_EMAIL'),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => '',
        ]);
    }
}
