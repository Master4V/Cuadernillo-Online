<?php

namespace App\Livewire\Profesor;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Grupo;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

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

    public function mount()
    {
        $this->loadData(); // Esto carga empresas y grupos

        $this->profesores = User::where('role', 'profesor')->get();
        $this->alumnos = User::where('role', 'alumno')
            ->whereDoesntHave('grupoComoAlumno')
            ->orWhereHas('grupoComoAlumno', function ($q) {
                $q->where('id', $this->grupoEditId);
            })
            ->get();
    }


    public function loadData()
    {
        $this->empresas = Empresa::all();
        $this->grupos = Grupo::with(['alumno', 'profesor', 'empresa'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->fresh(); // Fuerza recarga de relaciones
    }

    public function crearGrupo()
    {
        $rules = [
            'nuevoGrupo.empresa_id' => 'required|exists:empresas,id',
            'nuevoGrupo.profesor_id' => 'required|exists:users,id',
            'nuevoGrupo.centro_docente' => 'required|string',
            'nuevoGrupo.alumno_id' => [
                'required',
                'exists:users,id',
                Rule::unique('grupos', 'alumno_id')->ignore($this->grupoEditId)->whereNull('deleted_at'),
            ],
        ];

        $this->validate($rules);

        // Obtener datos relacionados
        $empresa = Empresa::find($this->nuevoGrupo['empresa_id']);
        $profesor = User::find($this->nuevoGrupo['profesor_id']);
        $alumno = User::find($this->nuevoGrupo['alumno_id']);

        $data = [
            'empresa_id' => $this->nuevoGrupo['empresa_id'],
            'profesor_id' => $this->nuevoGrupo['profesor_id'],
            'alumno_id' => $this->nuevoGrupo['alumno_id'],
            'centro_docente' => $this->nuevoGrupo['centro_docente'],
            'tutor_empresa' => $this->nuevoGrupo['tutor_empresa'],
            'empresa_practicas' => $empresa?->nombre ?? '',
            'nombre_profesor_practicas' => $profesor?->name ?? '',
            'nombre_alumno' => $alumno?->name ?? '', // Campo adicional si es necesario
        ];

        if ($this->isEditing) {
            Grupo::find($this->grupoEditId)->update($data);
            $message = 'Grupo actualizado correctamente!';
        } else {
            Grupo::create($data);
            $message = 'Grupo creado exitosamente!';
        }

        $this->cerrarModal();
        session()->flash('success', $message);
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
            // No necesitamos cargar los campos derivados (empresa_practicas, etc)
            // porque se volverán a calcular al guardar
        ];

        $this->grupoEditId = $grupoId;
        $this->isEditing = true;
        $this->showCreateModal = true;
    }

    public function cerrarModal()
    {
        $this->reset(['nuevoGrupo', 'showCreateModal', 'isEditing', 'grupoEditId']);
        $this->loadData();
    }

    public function updatedNuevoGrupoEmpresaId($value)
{
    $empresa = Empresa::find($value);
    $this->nuevoGrupo['tutor_empresa'] = $empresa->tutor ?? '';
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

            // Forzar recarga de datos
            $this->grupos = $this->grupos->filter(fn($g) => $g->id != $this->grupoToDelete->id);

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
