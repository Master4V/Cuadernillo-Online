<?php

namespace App\Livewire\Profesor;

use App\Models\Grupo;
use App\Models\Practica;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProgresoAlumnos extends Component
{
    public $mesSeleccionado;
    public $anoSeleccionado;
    public $meses = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
    ];
    public $anos;

    public function mount()
    {
        $this->mesSeleccionado = now()->month;
        $this->anoSeleccionado = now()->year;
        $this->anos = range(now()->year - 1, now()->year + 1);
    }

    public function render()
    {
        $profesorId = Auth::id();
        $totalDiasLectivos = $this->calcularDiasLectivos();
        
        // Obtener alumnos asignados al profesor
        $alumnos = User::whereHas('grupoComoAlumno', function($query) use ($profesorId) {
                        $query->where('profesor_id', $profesorId);
                    })
                    ->with(['practicas' => function($query) {
                        $query->whereMonth('fecha', $this->mesSeleccionado)
                              ->whereYear('fecha', $this->anoSeleccionado);
                    }])
                    ->get()
                    ->map(function($alumno) use ($totalDiasLectivos) {
                        return $this->calcularProgreso($alumno, $totalDiasLectivos);
                    });
        
        return view('livewire.profesor.progreso-alumnos', [
            'alumnos' => $alumnos,
            'totalDiasLectivos' => $totalDiasLectivos
        ]);
    }

    private function calcularProgreso($alumno, $totalDiasLectivos)
    {
        // Filtrar prácticas que son en días lectivos (L-V)
        $diasConRegistro = $alumno->practicas
            ->filter(function($practica) {
                $fecha = Carbon::parse($practica->fecha);
                return $fecha->isWeekday(); // Lunes a Viernes
            })
            ->unique('fecha')
            ->count();
        
        $progreso = $totalDiasLectivos > 0 
            ? round(($diasConRegistro / $totalDiasLectivos) * 100, 2)
            : 0;
            
        return (object)[
            'id' => $alumno->id,
            'name' => $alumno->name,
            'email' => $alumno->email,
            'progreso' => $progreso,
            'diasRegistrados' => $diasConRegistro,
            'totalDias' => $totalDiasLectivos,
            'practicas' => $alumno->practicas
        ];
    }

    private function calcularDiasLectivos()
    {
        return Carbon::create($this->anoSeleccionado, $this->mesSeleccionado, 1)
            ->daysUntil(Carbon::create($this->anoSeleccionado, $this->mesSeleccionado)->endOfMonth())
            ->filter(function($date) {
                return $date->isWeekday();
            })
            ->count();
    }

    public function cambiarMes($mes)
    {
        $this->mesSeleccionado = $mes;
    }

    public function cambiarAno($ano)
    {
        $this->anoSeleccionado = $ano;
    }
}