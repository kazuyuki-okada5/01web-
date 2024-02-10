<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\Auth\VerificationController;

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
    // ログインしている場合のみアクセス可能なルートをグループ化
    Route::get('/', [BookController::class, 'stamp']);
});

Route::prefix('book')->group(function () {
    // /book ルートにGETメソッドでアクセス可能なルートを追加
    Route::get('/', [BookController::class, 'stamp']);

    // /book ルートにPOSTメソッドでアクセス可能なルートを追加
    Route::post('/', [BookController::class, 'create']);
});

Route::post('/log-activity/{action}', [BookController::class, 'logActivity'])->name('log-activity');
Route::resource('books', 'BookController');

Route::get('/lists', [ListController::class, 'index']);
Route::resource('lists', ListController::class);

Route::get('/attendees/{date}', 'BookController@getAttendeesByDate')->name('attendees.by.date');
Route::get('/attendees/move/{direction}/{currentDate}', 'BookController@moveDate')->name('attendees.move.date');
Route::get('/attendees/date/{currentDate}', 'BookController@showByDate')
    ->name('attendees.showByDate');
Route::get('/attendees', [ListController::class, 'index'])->name('attendees.index');
Route::get('/attendees/move/{direction}/{currentDate}', [ListController::class, 'moveDate'])->name('attendees.move.date');
Route::get('/attendees/date/{currentDate}', [ListController::class, 'showByDate'])->name('attendees.showByDate');
Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}', [VerificationController::class, 'verify']);
Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');