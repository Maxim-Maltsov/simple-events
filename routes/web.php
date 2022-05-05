<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VotingController;
use Illuminate\Support\Facades\Route;

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


Route::get('/dashboard', function () {
    
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';



// My Route
Route::middleware('auth')->get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->get('event-form', [EventController::class, 'create'])->name('event-form');
Route::middleware('auth')->post('add-event', [EventController::class, 'store'])->name('add-event');


Route::middleware('auth')->get('voting-events', [VotingController::class, 'index'])->name('voting-events');

Route::middleware('auth')->get('voting-form', [VotingController::class, 'create'])->name('voting-form');
Route::middleware('auth')->post('add-voting', [VotingController::class, 'store'])->name('add-voting');

Route::middleware('auth')->get('voting-results', [VotingController::class, 'results'])->name('voting-results');
Route::middleware('auth')->get('voting-failed', [VotingController::class, 'failed'])->name('voting-failed');
Route::middleware('auth')->get('voting-finished', [VotingController::class, 'finished'])->name('voting-finished');

