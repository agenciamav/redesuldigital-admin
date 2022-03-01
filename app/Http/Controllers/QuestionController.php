<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;


class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Quiz $quiz)
    {
        return $quiz->questions;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Quiz $quiz, Request $request)
    {
        $quiz->questions()->create($request->all());
    }
}
