<?php

use App\Http\Controllers\CalculateController;
use App\Http\Controllers\FuzzyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Menampilkan form input
Route::get('/fuzzy', [FuzzyController::class, 'index'])->name('fuzzy.index');

// Memproses input dan menampilkan hasil
Route::post('/fuzzy/calculate', [CalculateController::class, 'fuzzy'])->name('fuzzy.calculate');
Route::get('/fuzzy/calculate', [CalculateController::class, 'fuzzy']);

