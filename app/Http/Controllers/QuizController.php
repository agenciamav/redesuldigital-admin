<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Submission;
use App\Exports\SubmissionsExport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseStatusCodeSame;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Quiz::with(['questions', 'sections'])->first());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // get the latest quiz
        $quiz = Quiz::latest()->with(['sections.questions'])->first();

        $answers = $request->answers;

        $submission = Submission::create([
            'quiz_id' => $quiz->id,
            'APS' => $request->meta['APS'],
            'city'  => $request->meta['city'],
            'state' => $request->meta['state'],
            'duration' => $request->meta['duration'],
            'progress' => $request->meta['progress'],
            'started_at' => $request->meta['startedAt'],
            'finished_at' => $request->meta['finishedAt'],
        ]);

        // foreach
        foreach ($submission->quiz->questions as $question) {
            $answer = $answers[$question->full_code] ?? null;
            if ($answer) {
                $submission->answers()->create([
                    'question_id' => $question->id,
                    'answer' => $answer,
                ]);
            }
        }

        return $submission;
    }




    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
        return response()->json($quiz);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz)
    {
        $quiz->update($request->all());
        return response()->json($quiz, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return response()->json(null, 204);
    }

    public function export()
    {
        return Excel::download(new SubmissionsExport, 'pesquisa.xlsx');
    }
}
