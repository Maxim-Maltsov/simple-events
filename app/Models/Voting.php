<?php

namespace App\Models;

use App\Events\StartVotingEvent;
use App\Exceptions\CanNotCreateNewVotingException;
use App\Exceptions\NoEventsException;
use App\Jobs\CalculateVotingJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Voting extends Model
{
    use HasFactory;


    const PHASE_1 = 1;
    const PHASE_2 = 2;
    const PHASE_ERROR = 0;


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_voting', 'voting_id', 'event_id')->using(EventVoting::class);
    }




    public static function getActiveVoting() :?Voting
    {
        return Voting::where('finished', 0)->first();
    }


    public static function canCreateVoting() :bool
    {
        $voting = Voting::getActiveVoting();

        if ( $voting instanceof Voting) {

            return false;
        }
        
        return true;
    }


    public static function add($request) :void
    {

        if (!Voting::canCreateVoting()) {

            throw new CanNotCreateNewVotingException('It is not possible to create a new vote, since the previous vote is not over yet.');
        }

        $events = Event::all();

        if ( $events->count() == 0) {

            throw new NoEventsException('It is impossible to create a vote, since there is not a single event.');
        }

        DB::transaction( function() use ($request, $events) {

            $voting = new Voting();

            $voting->user_id = Auth::id();
            $voting->time_phase_1 = $request['time_phase_1'] * 60;
            $voting->time_phase_2 = $request['time_phase_2'] * 60;
            $voting->start_timestamp_phase_1 = DB::raw('UNIX_TIMESTAMP()');
            $voting->start_timestamp_phase_2 = DB::raw('UNIX_TIMESTAMP() +' . $request['time_phase_1'] * 60);
            $voting->save();

            foreach ($events as $event) {

                $eventVoting = new EventVoting();

                $eventVoting->event_id = $event->id;
                $eventVoting->voting_id = $voting->id;
                $eventVoting->save();

                CalculateVotingJob::dispatch($voting, Voting::PHASE_1);
                StartVotingEvent::dispatch();
            }
        });
    }

    
    public function getCurrentPhase() :int
    {
        $nowTime = time();
        $endFirstPhaseTime = $this->start_timestamp_phase_1 + $this->time_phase_1;
        $endSecondPhaseTime = $this->start_timestamp_phase_2 + $this->time_phase_2;

        if ( $nowTime >= $this->start_timestamp_phase_1 && $nowTime <= $endFirstPhaseTime) {

            return Voting::PHASE_1;
        }

        if ( $nowTime >= $this->start_timestamp_phase_2 && $nowTime <= $endSecondPhaseTime) {

            return Voting::PHASE_2;
        }

        return Voting::PHASE_ERROR;
    }


    public function getTotalSeconds() :int
    {

        $nowTime = time();
        $endFirstPhaseTime = $this->start_timestamp_phase_1 + $this->time_phase_1;
        $endSecondPhaseTime = $this->start_timestamp_phase_2 + $this->time_phase_2;

        if ( $this->getCurrentPhase() == Voting::PHASE_1){

            return ($endFirstPhaseTime - $nowTime);
        }

        if ( $this->getCurrentPhase() == Voting::PHASE_2){

            return ($endSecondPhaseTime - $nowTime);
        }

        return 0;
    }
    

    public function getLikesAmount()
    {
      return  Like::query()
                    ->select(DB::raw('COUNT(*) as likes_amount'))
                    ->where('voting_id', $this->id)
                    ->value('likes_amount');
    }
    

    public function getWinnerEvent() :?Event
    {   
        $events = DB::select( "SELECT event_id FROM `likes` WHERE voting_id=:id GROUP BY event_id
                               ORDER BY COUNT(*) DESC LIMIT 1", [':id' => $this->id]);


        if ( is_array($events) && isset($events[0])) {

            return Event::where('id', $events[0]->event_id)->first();
        }
        else {

            return null;
        }
    }

    public function hasWinnerEvent() :bool
    {
    

        $events = DB::select( "SELECT event_id, COUNT(*) as likes_amount FROM `likes`
                               WHERE voting_id=:id GROUP BY event_id ORDER BY event_id ASC", [':id' => $this->id]);

        if (empty($events)) {

            return false;
        }

        $max_likes_amount = 0;

        foreach ($events as $event) {

            if ($max_likes_amount < $event->likes_amount) {
                $max_likes_amount = $event->likes_amount;
            }
        }

        $repeatedTotalValueLikes = 0;

        foreach ($events as $event) {

            if ( $max_likes_amount == $event->likes_amount) {
                 $repeatedTotalValueLikes++;
            }
        }

        if ($repeatedTotalValueLikes >= 2) {
            
            return false;
        }
        return true;
    }
}
