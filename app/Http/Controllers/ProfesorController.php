<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfeController extends Controller
{
    public function dashboard()
    {
        return view('profesor.dashboard');
    }
}
