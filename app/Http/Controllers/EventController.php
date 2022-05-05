<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function create()
    {
        return view('event-form');
    }


    public function store(EventRequest $request)
    {
        
        Event::add($request->validated());

        return redirect()->route('event-form')
                         ->with('message', 'Новое мероприятие добавленно.')
                         ->with('alert-type', 'success');
    }

}
