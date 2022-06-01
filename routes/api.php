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

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::apiResources([

        'events' => EventController::class,
        'likes' => LikeController::class,
        'members' => MemberController::class,
       
    ]);
});


Route::group(['middleware' => 'auth:sanctum'], function () {
    
    Route::get('voting-phase-one', [VotingController::class, 'getActiveVotingInPhaseOne']);
    Route::get('voting-phase-two', [VotingController::class, 'getActiveVotingInPhaseTwo']);
});
