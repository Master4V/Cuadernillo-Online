<?php

namespace App\Livewire\Profesor;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class AlumnoCrud extends Component
{
    use WithPagination;

    public $alumnos;
    public $modalVisible = false;
    public $deleteModalVisible = false;
    public $modoEdicion = false;
    public $alumnoId;
    public $alumnoAEliminar;

    public $name = '';
    public $email = '';
    public $password = '';
    public $search = '';

    protected $listeners = ['guardarAlumno' => 'guardarRegistro'];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|min:6',
    ];

    public function mount()
    {
        $this->cargarAlumnos();
    }

    public function cargarAlumnos()
    {
        $query = User::where('role', 'alumno')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('id');

        $this->alumnos = $query->get();
    }

    public function updatedSearch($value)
    {
        $this->cargarAlumnos();
    }

    public function abrirModal()
    {
        $this->resetFormulario();
        $this->resetValidation();
        $this->modalVisible = true;
    }

    public function editarAlumno($id)
    {
        $this->modoEdicion = true;
        $alumno = User::findOrFail($id);
        $this->alumnoId = $alumno->id;
        $this->name = $alumno->name;
        $this->email = $alumno->email;

        $this->rules['email'] = 'required|email|max:255|unique:users,email,' . $this->alumnoId;
        $this->rules['password'] = 'nullable|min:6';

        $this->modalVisible = true;
    }

    public function confirmarEliminacion($id)
    {
        $this->alumnoAEliminar = $id;
        $this->deleteModalVisible = true;
    }

    public function eliminarAlumno()
    {
        User::findOrFail($this->alumnoAEliminar)->delete();
        $this->deleteModalVisible = false;
        $this->cargarAlumnos();
        $this->dispatch('registroGuardado');
        session()->flash('message', 'Alumno eliminado correctamente.');
    }

    public function guardarAlumno()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->alumnoId)->whereNull('deleted_at'),
            ],
            'password' => $this->modoEdicion ? 'nullable|min:6' : 'required|min:6',
        ]);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => 'alumno'
        ];

        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->modoEdicion) {
            User::findOrFail($this->alumnoId)->update($data);
            $message = 'Alumno actualizado correctamente.';
        } else {
            // Verifica si hay un alumno eliminado con ese email
            $alumnoEliminado = User::withTrashed()
                ->where('email', $this->email)
                ->where('role', 'alumno')
                ->first();

            if ($alumnoEliminado && $alumnoEliminado->trashed()) {
                $alumnoEliminado->restore();
                $alumnoEliminado->update($data);
                $message = 'Alumno restaurado y actualizado correctamente.';
            } else {
                User::create($data);
                $message = 'Alumno creado correctamente.';
            }
        }

        $this->cerrarModal();
        $this->cargarAlumnos();
        $this->dispatch('registroGuardado');
        session()->flash('message', $message);
    }


    public function cerrarModal()
    {
        $this->modalVisible = false;
        $this->deleteModalVisible = false;
        $this->modoEdicion = false;
        $this->resetFormulario();
        $this->resetValidation();
    }

    public function resetFormulario()
    {
        $this->reset(['name', 'email', 'password', 'alumnoId', 'alumnoAEliminar']);
        // Restaurar reglas de validación originales
        $this->rules['email'] = 'required|email|max:255|unique:users,email';
        $this->rules['password'] = 'required|min:6';
    }

    public function render()
    {
        return view('livewire.profesor.alumno-crud');
    }
}
