<?php

use App\Http\Controllers\Api\v1\EventController;
use App\Http\Controllers\Api\v1\LikeController;
use App\Http\Controllers\Api\v1\MemberController;
use App\Http\Controllers\Api\v1\VotingController;
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


Route::apiResources([

    'events' => EventController::class,
]);


Route::get('voting-phase-one', [VotingController::class, 'getActiveVotingInPhaseOne'])->middleware('auth:sanctum');

Route::post('likes', [LikeController::class, 'store'])->middleware('auth:sanctum');

Route::get('voting-phase-two', [VotingController::class, 'getActiveVotingInPhaseTwo'])->middleware('auth:sanctum');

Route::post('members', [MemberController::class, 'store'])->middleware('auth:sanctum');