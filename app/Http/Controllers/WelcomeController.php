<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class WelcomeController extends Controller
{
    public function index()
    {
        $date = Jalalian::forge('today')->format('%A, %d %B %Y');
        return view('welcome', compact('date'));
    }
}
