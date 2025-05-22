<?php

namespace App\Http\Controllers;

use App\Models\Practica;
use App\Models\Grupo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Support\Str;

class AlumnoPDFController extends Controller
{
    public function generate()
    {
        $alumno = Auth::user();

        $grupo = Grupo::with(['profesor', 'empresa'])
            ->where('alumno_id', $alumno->id)
            ->first();

        $practicas = Practica::where('user_id', $alumno->id)
            ->orderBy('fecha', 'asc')
            ->get();

        $totalHoras = $practicas->sum('horas');

        $pdf = PDF::loadView('alumno.pdf', [
            'alumno' => $alumno,
            'grupo' => $grupo,
            'practicas' => $practicas,
            'totalHoras' => $totalHoras
        ]);

        $nombreArchivo = 'Cuadernillo_de_practicas_de_' . Str::slug($alumno->name) . '.pdf';

        return $pdf->stream($nombreArchivo);
    }
}
