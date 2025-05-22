<?php

namespace App\Livewire\Profesor;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Grupo;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Validation\Rule;

class AsignarEmpresa extends Component
{
    use WithPagination;

    public $grupos;
    public $empresas;
    public $profesores;
    public $alumnos;

    // Campos para nuevo grupo
    public $showCreateModal = false;
    public $nuevoGrupo = [
        'empresa_id' => '',
        'profesor_id' => '',
        'alumno_id' => '',
        'centro_docente' => 'IES La Marisma',
        'tutor_empresa' => ''
    ];

    //Campos editar
    public $isEditing = false;
    public $grupoEditId = null;

    // Campos para eliminar
    public $showDeleteModal = false;
    public $grupoToDelete;

    //Campos CRUDs
    public $showEmpresasModal = false;
    public $showAlumnosModal = false;

    public $search = '';

    protected $listeners = ['registroGuardado' => 'actualizarDatos'];

    public function actualizarDatos()
    {
        $this->loadData();
        $this->loadAlumnosDisponibles();
    }

    public function mount()
    {
        $this->loadData();
        $this->loadAlumnosDisponibles();
        $this->profesores = User::where('role', 'profesor')->get();
        $this->empresas = Empresa::all();
    }


    public function loadData()
    {
        $this->grupos = Grupo::with(['alumno', 'profesor', 'empresa'])
            ->when($this->search, function ($query) {
                $query->whereHas('alumno', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                    ->orWhereHas('profesor', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('empresa', function ($q) {
                        $q->where('nombre', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->fresh();
    }

    public function updatedSearch($value)
    {
        $this->loadData();
    }

    public function crearGrupo()
    {
        $rules = [
            'nuevoGrupo.empresa_id' => 'required|exists:empresas,id',
            'nuevoGrupo.profesor_id' => 'required|exists:users,id',
            'nuevoGrupo.centro_docente' => 'required|string',
            'nuevoGrupo.tutor_empresa' => 'required|string',
            'nuevoGrupo.alumno_id' => [
                'required',
                'exists:users,id',
                Rule::unique('grupos', 'alumno_id')->ignore($this->grupoEditId)->whereNull('deleted_at'),
            ],
        ];

        $this->validate($rules);

        $empresa = Empresa::find($this->nuevoGrupo['empresa_id']);
        $profesor = User::find($this->nuevoGrupo['profesor_id']);

        $data = [
            'empresa_id' => $this->nuevoGrupo['empresa_id'],
            'profesor_id' => $this->nuevoGrupo['profesor_id'],
            'alumno_id' => $this->nuevoGrupo['alumno_id'],
            'centro_docente' => $this->nuevoGrupo['centro_docente'],
            'tutor_empresa' => $this->nuevoGrupo['tutor_empresa'],
            'empresa_practicas' => $empresa?->nombre ?? '',
            'nombre_profesor_practicas' => $profesor?->name ?? '',
        ];

        if ($this->isEditing) {
            Grupo::find($this->grupoEditId)->update($data);
            $message = 'Grupo actualizado correctamente!';
        } else {
            Grupo::create($data);
            $message = 'Grupo creado exitosamente!';
        }

        $this->loadAlumnosDisponibles();

        $this->cerrarModal();
        session()->flash('success', $message);
    }

    public function loadAlumnosDisponibles()
    {
        $this->alumnos = User::where('role', 'alumno')
            ->where(function ($query) {
                $query->whereDoesntHave('grupoComoAlumno')
                    ->orWhereHas('grupoComoAlumno', function ($q) {
                        $q->where('id', $this->grupoEditId);
                    });
            })
            ->orderBy('name')
            ->get();
    }

    public function editarGrupo($grupoId)
    {
        $grupo = Grupo::findOrFail($grupoId);

        $this->nuevoGrupo = [
            'empresa_id' => $grupo->empresa_id,
            'profesor_id' => $grupo->profesor_id,
            'alumno_id' => $grupo->alumno_id,
            'centro_docente' => $grupo->centro_docente,
            'tutor_empresa' => $grupo->tutor_empresa,
        ];

        $this->grupoEditId = $grupoId;
        $this->isEditing = true;
        $this->showCreateModal = true;
        $this->loadAlumnosDisponibles();
    }

    public function cerrarModal()
    {
        $this->reset([
            'nuevoGrupo',
            'showCreateModal',
            'showEmpresasModal',
            'showAlumnosModal',
            'isEditing',
            'grupoEditId'
        ]);
        $this->loadData();
        $this->loadAlumnosDisponibles();
    }

    public function updatedNuevoGrupoEmpresaId($value)
    {
        if ($value) {
            $empresa = Empresa::find($value);
            $this->nuevoGrupo['tutor_empresa'] = $empresa->tutor ?? '';
        } else {
            $this->nuevoGrupo['tutor_empresa'] = '';
        }
    }


    public function confirmarEliminar($grupoId)
    {
        $this->grupoToDelete = Grupo::find($grupoId);

        if ($this->grupoToDelete) {
            $this->showDeleteModal = true;
        } else {
            session()->flash('error', 'No se encontró el grupo para eliminar.');
        }
    }


    public function eliminarGrupo()
    {
        if ($this->grupoToDelete) {
            $this->grupoToDelete->delete();

            $this->grupos = $this->grupos->filter(fn($g) => $g->id != $this->grupoToDelete->id);
            $this->loadAlumnosDisponibles();
            $this->reset(['grupoToDelete', 'showDeleteModal']);
            $this->dispatch('refreshComponent');
        }

        session()->flash('success', 'Grupo eliminado exitosamente!');
    }


    public function render()
    {
        return view('livewire.profesor.asignar-empresa');
    }

    public function refreshComponent()
    {
        $this->loadData();
        $this->render();
    }
}
