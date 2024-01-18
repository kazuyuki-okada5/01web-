<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;

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

Route::middleware('auth')->group(function () {
    Route::get('/', [AuthController::class, 'stamp']);
});
Route::get('/attendees', [AuthorController::class, 'index']);
Route::prefix('book')->group(function () {
    Route::get('/book', [BookController::class, 'index']);
    Route::get('/add', [BookController::class, 'add']);
    Route::post('/add', [BookController::class, 'create']);
    });
Route::get('/relation', [AuthorController::class, 'relate']);