<?php

namespace App\Livewire\Profesor;

use App\Models\Empresa;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class EmpresaCrud extends Component
{
    use WithPagination;

    public $empresas;
    public $modalVisible = false;
    public $deleteModalVisible = false;
    public $modoEdicion = false;
    public $empresaId;
    public $empresaAEliminar;

    public $nombre = '';
    public $direccion = '';
    public $telefono = '';
    public $mail = '';
    public $tutor = '';

    protected $rules = [
        'nombre' => 'required|string|max:255|unique:empresas,nombre',
        'direccion' => 'required|string|max:255|unique:empresas,direccion',
        'telefono' => 'required|string|max:20|unique:empresas,telefono',
        'mail' => 'nullable|email',
        'tutor' => 'required|string|max:255',
    ];

    protected $listeners = ['guardarEmpresa' => 'guardarRegistro'];

    public function mount()
    {
        $this->cargarEmpresas();
    }

    public function cargarEmpresas()
    {
        $this->empresas = Empresa::orderBy('id')->get();
    }

    public function abrirModal()
    {
        $this->resetFormulario();
        $this->resetValidation();
        $this->modalVisible = true;
    }

    public function editarEmpresa($id)
    {
        $this->modoEdicion = true;
        $empresa = Empresa::findOrFail($id);
        $this->empresaId = $empresa->id;
        $this->nombre = $empresa->nombre;
        $this->direccion = $empresa->direccion;
        $this->telefono = $empresa->telefono;
        $this->mail = $empresa->mail;
        $this->tutor = $empresa->tutor;

        $this->rules['nombre'] = 'required|string|max:255|unique:empresas,nombre,' . $this->empresaId;
        $this->rules['direccion'] = 'required|string|max:255|unique:empresas,direccion,' . $this->empresaId;
        $this->rules['telefono'] = 'required|string|max:20|unique:empresas,telefono,' . $this->empresaId;

        $this->modalVisible = true;
    }

    public function confirmarEliminacion($id)
    {
        $this->empresaAEliminar = $id;
        $this->deleteModalVisible = true;
    }

    public function eliminarEmpresa()
    {
        Empresa::findOrFail($this->empresaAEliminar)->delete();
        $this->deleteModalVisible = false;
        $this->cargarEmpresas();
        $this->dispatch('registroGuardado');
        session()->flash('message', 'Empresa eliminada correctamente.');
    }

    public function guardarRegistro()
    {
        $this->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('empresas')->ignore($this->empresaId)->whereNull('deleted_at'),
            ],
            'direccion' => [
                'required',
                'string',
                'max:255',
                Rule::unique('empresas')->ignore($this->empresaId)->whereNull('deleted_at'),
            ],
            'telefono' => [
                'required',
                'string',
                'max:20',
                Rule::unique('empresas')->ignore($this->empresaId)->whereNull('deleted_at'),
            ],
            'mail' => 'nullable|email',
            'tutor' => 'required|string|max:255',
        ]);

        $data = [
            'nombre' => $this->nombre,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'mail' => $this->mail,
            'tutor' => $this->tutor,
        ];

        if ($this->modoEdicion) {
            Empresa::findOrFail($this->empresaId)->update($data);
            $message = 'Empresa actualizada correctamente.';
        } else {
            // Buscar si hay una empresa eliminada con ese nombre
            $empresaEliminada = Empresa::withTrashed()->where('nombre', $this->nombre)->first();

            if ($empresaEliminada && $empresaEliminada->trashed()) {
                $empresaEliminada->restore();
                $empresaEliminada->update($data);
                $message = 'Empresa restaurada y actualizada correctamente.';
            } else {
                Empresa::create($data);
                $message = 'Empresa creada correctamente.';
            }
        }

        $this->cerrarModal();
        $this->cargarEmpresas();
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
        $this->reset(['nombre', 'direccion', 'telefono', 'mail', 'tutor', 'empresaId', 'empresaAEliminar']);
        $this->rules['nombre'] = 'required|string|max:255|unique:empresas,nombre';
        $this->rules['direccion'] = 'required|string|max:255|unique:empresas,direccion';
        $this->rules['telefono'] = 'required|string|max:20|unique:empresas,telefono';
    }

    public function render()
    {
        return view('livewire.profesor.empresa-crud');
    }
}
