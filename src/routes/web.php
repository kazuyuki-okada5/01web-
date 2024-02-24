<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\Auth\VerificationController;
use App\Models\Book;
use App\Http\Controllers\UserListController;
use App\Http\Controllers\TotalBreakSecondController;

Route::middleware('auth')->group(function () {
    Route::get('/', [BookController::class, 'stamp']);
});

Route::prefix('book')->group(function () {
    Route::get('/', [BookController::class, 'stamp']);
    Route::post('/', [BookController::class, 'create']);
});

Route::get('/users_list', [UserListController::class, 'index'])->name('users.index');


Route::post('/log-activity/{action}', [BookController::class, 'logActivity'])->name('log-activity');
Route::resource('books', 'BookController');

Route::get('/lists', [ListController::class, 'index']);
Route::resource('lists', ListController::class);

Route::get('/attendees/{date}', 'BookController@getAttendeesByDate')->name('attendees.by.date');
Route::get('/attendees/move/{direction}/{currentDate}', 'BookController@moveDate')->name('attendees.move.date');
Route::get('/attendees/date/{currentDate}', 'BookController@showByDate')->name('attendees.showByDate');
Route::get('/attendees', [ListController::class, 'index'])->name('attendees.index');
Route::get('/attendees/move/{direction}/{currentDate}', [ListController::class, 'moveDate'])->name('attendees.move.date');
Route::get('/attendees/date/{currentDate}', [ListController::class, 'showByDate'])->name('attendees.showByDate');

Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}', [VerificationController::class, 'verify']);
Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::get('/calculate-total-break-seconds', [TotalBreakSecondController::class, 'calculateAndSaveTotalBreakSeconds']);
