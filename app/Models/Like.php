<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;


    protected $fillable = ['voting_id','event_id',];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public static function getVotedUsers() :array
    {

        $voting = Voting::getActiveVoting();
        
        if ( $voting == null) {

            return [];
        }

        $users = [];

        $likes = Like::where( 'voting_id', $voting->id )->where( 'event_id', $voting->winned_event_id )->get();
        
        foreach ($likes as $like) {

            $users[] = $like->user;
        }

        return $users;
    }
}
