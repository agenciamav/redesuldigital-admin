<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Submission;
use App\Exports\SubmissionsExport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseStatusCodeSame;
use \App\Services\GoogleSheets;

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
        $meta = $request->meta;

        $submission = Submission::updateOrCreate(
            ['id' => $request->id ?? null],
            [
                'quiz_id' => $quiz->id,
                'name' => $meta['name'],
                'city'  => $meta['city'],
                'state' => $meta['state'],
                'duration' => $meta['duration'],
                'progress' => $meta['progress'],
                'started_at' => $meta['startedAt'],
                'finished_at' => $meta['finishedAt'],
            ]
        );

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

        // Save on Google Sheets
        // $values = json_decode('[{"COD":"0026","CIDADE":"","TESTE":"Teste2","A.1":"Teste3","A.2":null,"NOME":"Teste"},{"CIDADE":"","ID":"00246","TESTE":"Teste2","A.1":"Teste 564","A.2":null,"NOME":"Jo\u00e3o","UNDEF":"Teste2"},{"CIDADE":"Iju\u00ed - RS","COD":"00246","TESTE":"Teste2","A.1":"Teste 564","A.2":null,"NOME":"Luciano T. de Souza"}]');
        $googleSheets = resolve(GoogleSheets::class);

        // $submission = collect($submission)->toArray();
        $data = array_merge(
            [
                'ID' => $submission->id,
                'NOME' => $meta['name'],
                'CIDADE' => $meta['city'],
                'ASSINATURA' => null,
                'INÍCIO' => $meta['startedAt'],
                'DURAÇÃO' => $meta['duration'],
                'TÉRMINO' => $meta['finishedAt'],
            ],
            $answers,
        );

        $data = $googleSheets->appendValues('Respostas', [$data]);

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
