<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    const TAKE_PART = 1;
    const NO_TAKE_PART = 0;

    protected $fillable = [ 'voting_id','winned_event_id', 'action'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public static function getAll(?Voting $voting)
    {
        if ( $voting == null) {

            return [];
        }

        $users = [];

        $members = Member::where('voting_id', $voting->id)->where('action', Member::TAKE_PART)->orderBy('id', 'asc')->get();
                  
        foreach ( $members as $member) {

            $users[] = $member->user;
        }
        
        return $users;
    }



    public static function userMadeChoice(Voting $voting, int $id) :bool
    {
        $member = Member::where('voting_id', $voting->id)->where('user_id', $id)->first();

        if ($member instanceof Member) {

            return true;
        }

        return false;
    }
}
