<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('quizzes', 'QuizController')->middleware('auth:sanctum');

// Get the questions for a quiz
Route::get('quizzes/{quiz}/questions', [QuestionController::class, 'index']);

// Save the answers for a quiz
Route::post('quizzes/{quiz}/answers', [QuestionController::class, 'store']);