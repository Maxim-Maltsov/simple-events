<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function votings()
    {
        return $this->hasMany(Voting::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }


    public static function voted(Voting $voting, int $id) :bool
    {
        $like = Like::where('voting_id', $voting->id)->where('user_id', $id)->first();

        if ($like instanceof Like) {

            return true;
        }

        return false;
    }


    public static function getVotedAll(?Voting $voting) :array
    {
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
