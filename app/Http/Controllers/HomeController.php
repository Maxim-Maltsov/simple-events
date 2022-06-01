<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() 
    {   
        $token = session('API-Token');

        return view('events', ['token' => $token]);
    }
}
