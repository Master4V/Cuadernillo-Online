<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfesorController extends Controller
{
    public function dashboard()
    {
        return view('profesor.dashboard');
    }

    public function asignaciones(){
        return view('profesor.asignaciones');
    }
}
