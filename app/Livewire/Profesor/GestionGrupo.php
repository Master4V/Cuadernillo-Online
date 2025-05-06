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
    protected string $paginationTheme = 'tailwind';

    protected $listeners = ['alumnoActualizado' => 'actualizarDatos'];

    public function render()
    {
        $profesorId = Auth::id();
        $cursoActual = date('Y') . '/' . (date('Y') + 1);

        $alumnos = $this->getAlumnosQuery($profesorId, $cursoActual)
                      ->paginate(10);

        $totalAsignados = Grupo::where('profesor_id', $profesorId)
                             ->where('curso_academico', $cursoActual)
                             ->count();

        return view('livewire.profesor.gestion-grupo', [
            'alumnos' => $alumnos,
            'totalAsignados' => $totalAsignados
        ]);
    }

    protected function getAlumnosQuery($profesorId, $cursoActual)
{
    return User::where('role', 'alumno')
        ->when($this->search, function($q) {
            return $q->where(function($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('email', 'like', '%'.$this->search.'%');
            });
        })
        ->when($this->showAsignados, function($q) use ($profesorId, $cursoActual) {
            return $q->whereHas('grupoComoAlumno', function($query) use ($profesorId, $cursoActual) {
                $query->where('profesor_id', $profesorId)
                      ->where('curso_academico', $cursoActual);
            });
        }, function($q) use ($cursoActual) {
            return $q->whereDoesntHave('grupoComoAlumno', function($query) use ($cursoActual) {
                $query->where('curso_academico', $cursoActual);
            });
        })
        ->orderBy('name'); // Asegura un orden estable
}


    public function toggleAsignacion($alumnoId)
    {
        $profesorId = Auth::id();
        $cursoActual = date('Y') . '/' . (date('Y') + 1);

        $grupo = Grupo::where('profesor_id', $profesorId)
                  ->where('alumno_id', $alumnoId)
                  ->first();

        if ($grupo) {
            $grupo->delete();
            $message = 'Alumno eliminado del grupo';
        } else {
            Grupo::create([
                'profesor_id' => $profesorId,
                'alumno_id' => $alumnoId,
                'curso_academico' => $cursoActual
            ]);
            $message = 'Alumno añadido al grupo';
        }

        $this->dispatch('alumnoActualizado')->to(ProgresoAlumnos::class);
        $this->dispatch('notify', 
            type: 'success', 
            message: $message
        );
        
        // Forzar recarga sin usar caché
        $this->render();
    }

    public function actualizarDatos()
    {
        $this->render();
    }

    public function toggleVista()
    {
        $this->showAsignados = !$this->showAsignados;
        $this->resetPage(); // Esto ahora funcionará correctamente
    }
}