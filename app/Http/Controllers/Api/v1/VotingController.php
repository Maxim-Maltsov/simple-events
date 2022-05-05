<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Voting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VotingController extends Controller
{

    public function getActiveVotingInPhaseOne() 
    {
        
        $voting = Voting::getActiveVoting();

        if ( $voting == null ) {

            return response()->json([ 'data' => [

                'error' => 'Active voting not found!',
            ]]);
        }
        
        $events = $voting->events()->get();
        $totalSeconds = $voting->getTotalSeconds();
        $likesAmount = $voting->getLikesAmount();

        return response()->json([ 'data' => [
            
            'voting' => $voting,
            'events' => $events,
            'totalSeconds' => $totalSeconds,
            'likesAmount' => $likesAmount,
        ]]);
    }



    public function getActiveVotingInPhaseTwo() 
    {
        
        $voting = Voting::getActiveVoting();
        $id = Auth::id();

        if ( $voting == null ) {

            return response()->json([ 'data' => [

                'error' => 'Active voting not found!',
            ]]);
        }
        
        $events = $voting->events()->get();
        $totalSeconds = $voting->getTotalSeconds();

        $winnerEvent = $voting->getWinnerEvent();
        $members = Member::getAll($voting);
        $userMadeChoice = Member::userMadeChoice($voting, $id);

        return response()->json([ 'data' => [
            
            'voting' => $voting,
            'events' => $events,
            'totalSeconds' => $totalSeconds,
            'winnerEvent' =>  $winnerEvent,
            'members' => $members,
            'userMadeChoice' => $userMadeChoice,
        ]]);
    }
    
}
