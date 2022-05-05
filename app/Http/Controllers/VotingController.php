<?php

namespace App\Http\Controllers;

use App\Exceptions\CanNotCreateNewVotingException;
use App\Exceptions\NoEventsException;
use App\Http\Requests\VotingRequest;
use App\Models\Voting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class VotingController extends Controller
{
    public function index()
    {   
        $token = session('API-Token');

        return view('voting-events', ['token' => $token ]);
    }

    public function create()
    {
        return view('voting-form');
    }


    public function store(VotingRequest $request)
    {   
        try {

            Session::flash('message', 'Голосование запущено.');
            Session::flash('alert-type', 'success');

            Voting::add($request->validated());
        }
        catch(CanNotCreateNewVotingException $e) {

            Log::info($e->getMessage());
            return redirect()->route('voting-form')
                             ->with('message', 'Невозможно создать новое голосование, так как предыдущее голосование ещё не окончено.')
                             ->with('alert-type', 'danger');
        }  
        catch(NoEventsException $e) {

            Log::info($e->getMessage());
            return redirect()->route('voting-form')
                             ->with('message', 'Невозможно создать новое голосование, так как нет ни одного мероприятия.')
                             ->with('alert-type', 'danger');
        } 
    }


    public function results()
    {
        $token = session('API-Token');

        return view('voting-results', ['token' => $token ]);
    }


    public function failed()
    {   
        return view('voting-failed');
    }


    public function finished() 
    {
        return view('voting-finished');
    }

}
