<?php

namespace App\Livewire\Profesor;

use App\Models\Grupo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class GestionGrupo extends Component
{
    use WithPagination;

    public $search = '';
    public $showAsignados = false;

    public function render()
{
    $profesorId = Auth::id();
    $cursoActual = date('Y') . '/' . (date('Y') + 1);

    // Todos los alumnos asignados en el curso actual (sin importar profesor)
    $alumnosAsignados = Grupo::where('curso_academico', $cursoActual)
                             ->pluck('alumno_id')
                             ->toArray();

    // Alumnos asignados a este profesor
    $asignadosAlProfesor = Grupo::where('profesor_id', $profesorId)
                                ->where('curso_academico', $cursoActual)
                                ->pluck('alumno_id')
                                ->toArray();

    // Base query
    $alumnosQuery = User::where('role', 'alumno')
                        ->when($this->search, function($q) {
                            return $q->where(function ($query) {
                                $query->where('name', 'like', '%' . $this->search . '%')
                                      ->orWhere('email', 'like', '%' . $this->search . '%');
                            });
                        });

    // Mostrar alumnos asignados al profesor o los que no tienen ningún grupo
    if ($this->showAsignados) {
        $alumnosQuery->whereIn('id', $asignadosAlProfesor);
    } else {
        $alumnosQuery->whereNotIn('id', $alumnosAsignados);
    }

    $alumnos = $alumnosQuery->paginate(10);

    return view('livewire.profesor.gestion-grupo', [
        'alumnos' => $alumnos,
        'totalAsignados' => count($asignadosAlProfesor)
    ]);
}


    public function toggleAsignacion($alumnoId)
{
    $profesorId = Auth::id();

    // Verificar si el alumno ya está asignado a este profesor
    $grupo = Grupo::where('profesor_id', $profesorId)
                  ->where('alumno_id', $alumnoId)
                  ->first();

    if ($grupo) {
        // Ya está asignado → lo quitamos
        $grupo->delete();

        $this->dispatch('notify', ['type' => 'success', 'message' => 'Alumno eliminado del grupo']);
    } else {
        // No está asignado → lo añadimos
        Grupo::create([
            'profesor_id' => $profesorId,
            'alumno_id' => $alumnoId,
            'curso_academico' => date('Y') . '/' . (date('Y') + 1)
        ]);

        $this->dispatch('notify', ['type' => 'success', 'message' => 'Alumno añadido al grupo']);
    }

    $this->resetPage(); // Para refrescar el listado
}


    public function toggleVista()
    {
        $this->showAsignados = !$this->showAsignados;
        $this->resetPage();
    }
}