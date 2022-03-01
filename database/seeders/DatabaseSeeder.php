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


        $quizSections = json_decode(file_get_contents(__DIR__ . './questions.json'), true);

        foreach ($quizSections['questions'] as $section) {
            if (Arr::exists($section, 'questions')) {
                foreach ($section['questions'] as $question) {
                    // create section if not exists
                    $sectionModel = \App\Models\Section::firstOrCreate(
                        ['letter' => $section['id'], 'quiz_id' => $quiz->id],
                        [
                            'title' => $section['title'],
                            'description' => $section['description'] ?? null,
                        ]
                    );

                    // create question
                    $sectionModel->questions()->create([
                        'quiz_id' => $quiz->id,
                        'type' =>  $question['type'] ?? '',
                        'options' => json_encode($question['options'] ?? ''),
                        'text' => $question['text'] ?? '',
                    ]);
                }
            }
        }


        // $questionsJson = ;
    }
}
