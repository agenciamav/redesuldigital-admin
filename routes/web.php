<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\QuizController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function (\App\Services\GoogleSheets $googleSheets) {

    $data = $googleSheets->getSheet('Worksheet');

    return Inertia::render('Dashboard', [
        'data' => $data,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard/export/', [QuizController::class, 'export'])
    ->middleware(['auth', 'verified']);

require __DIR__ . '/auth.php';
