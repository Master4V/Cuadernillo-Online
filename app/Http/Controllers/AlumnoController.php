<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function dashboard()
    {
        return view('alumno.dashboard');
    }
    
    public function datos()
    {
        return view('alumno.datos'); 
    }
}