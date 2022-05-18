<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\AddedNewMemberEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRequest;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Resource_;

class MemberController extends Controller
{
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MemberRequest $request)
    {   
        $member = new Member($request->validated());
        $member->user_id = Auth::id();
        $member->save();

        $user = $member->user;
        $action = $member->action;

        AddedNewMemberEvent::dispatch($user, $action);

        return new MemberResource($member);
    }

}
