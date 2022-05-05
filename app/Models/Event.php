<?php

namespace App\Models;

use App\Events\AddedNewEventEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description'];


    public function user(){
        
        return $this->belongsTo(User::class);
    }


    public function votings(){
        
        return $this->belongsToMany(User::class, 'event_voting','event_id','voting_id')->using(EventVoting::class);
    }


    public static function add($request)
    {
        $event = new Event($request);

        $event->user_id = Auth::id();
        $event->save();

        AddedNewEventEvent::dispatch($event);
    }

}
