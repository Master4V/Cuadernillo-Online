<?php

namespace App\Livewire\Alumno;

use Livewire\Component;
use App\Models\Grupo;
use Illuminate\Support\Facades\Auth;

class DatosGrupo extends Component
{
    public $isOpen = false; // Controla el modal
    public $expanded = false; // Controla el acordeón
    
    // Campos del formulario
    public $nombre_profesor_practicas;
    public $empresa_practicas;
    public $monitor_empresa;
    public $grado_estudiante;
    public $curso_academico;
    
    protected $rules = [
        'nombre_profesor_practicas' => 'nullable|string|max:255',
        'empresa_practicas' => 'nullable|string|max:255',
        'monitor_empresa' => 'nullable|string|max:255',
        'grado_estudiante' => 'nullable|string|max:255',
        'curso_academico' => 'nullable|string|max:255'
    ];

    public function mount()
    {
        $this->loadGrupoData();
    }
    
    public function loadGrupoData()
    {
        $grupo = Auth::user()->grupoComoAlumno;
        
        if ($grupo) {
            $this->nombre_profesor_practicas = $grupo->nombre_profesor_practicas;
            $this->empresa_practicas = $grupo->empresa_practicas;
            $this->monitor_empresa = $grupo->monitor_empresa;
            $this->grado_estudiante = $grupo->grado_estudiante;
            $this->curso_academico = $grupo->curso_academico;
        }
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->loadGrupoData(); // Recarga los datos originales al cancelar
    }

    public function save()
    {
        $this->validate();
        
        $grupo = Auth::user()->grupoComoAlumno;
        
        if ($grupo) {
            $grupo->update([
                'nombre_profesor_practicas' => $this->nombre_profesor_practicas,
                'empresa_practicas' => $this->empresa_practicas,
                'monitor_empresa' => $this->monitor_empresa,
                'grado_estudiante' => $this->grado_estudiante,
                'curso_academico' => $this->curso_academico
            ]);
            
            $this->closeModal();
            session()->flash('message', 'Datos actualizados correctamente');
        }
    }

    public function toggleAccordion()
    {
        $this->expanded = !$this->expanded;
    }

    public function render()
    {
        $grupo = Auth::user()->grupoComoAlumno;
        $profesor = $grupo ? $grupo->profesor : null;
        
        return view('livewire.alumno.datos-grupo', [
            'grupo' => $grupo,
            'profesor' => $profesor
        ]);
    }
}