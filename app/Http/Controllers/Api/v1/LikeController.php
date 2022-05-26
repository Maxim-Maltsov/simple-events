<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\AddedNewLikeEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\LikeRequest;
use App\Http\Resources\LikeResource;
use App\Models\Like;
use App\Models\Voting;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LikeRequest $request)
    {
        $newLike = new Like($request->validated());
        $newLike->user_id = Auth::id();
        $newLike->save();

        $voting = Voting::getActiveVoting();
        AddedNewLikeEvent::dispatch($voting->getLikesAmount());

        return new LikeResource($newLike);
    }
}
