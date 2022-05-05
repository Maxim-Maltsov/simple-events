<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [

            'id' => $this->id,
            'voting_id' => $this->voting_id,
            'winned_event_id' => $this->winned_event_id,
            'user_id' => $this->user_id,
            'action' => $this->action,
            'created_at' => $this->created_at,
        ];
    }
}
