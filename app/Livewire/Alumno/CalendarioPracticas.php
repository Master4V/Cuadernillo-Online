<?php

namespace App\Livewire\Alumno;

use Livewire\Component;
use App\Models\Practica;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CalendarioPracticas extends Component
{
    public $fechaSeleccionada;
    public $showModal = false;
    public $actividad = '';
    public $horas = 0;
    public $observaciones = '';
    public $fechaActual;
    public $mostrarDatepicker = false;
    public $practicaExistente = false;
    public $practicas = [];
    
    protected $rules = [
        'actividad' => 'required|min:3',
        'horas' => 'required|numeric|min:1',
        'observaciones' => 'nullable|string',
    ];
    
    public function mount()
    {
        $this->fechaActual = now()->format('Y-m-d');
        $this->cargarPracticas();
    }
    
    public function cargarPracticas()
    {
        $this->practicas = Practica::where('user_id', Auth::id())
            ->whereMonth('fecha', Carbon::parse($this->fechaActual)->month)
            ->whereYear('fecha', Carbon::parse($this->fechaActual)->year)
            ->get()
            ->keyBy(function ($item) {
                return Carbon::parse($item->fecha)->format('Y-m-d');
            });
    }
    
    public function mesAnterior()
    {
        $this->fechaActual = Carbon::parse($this->fechaActual)->subMonth()->format('Y-m-d');
        $this->cargarPracticas();
        $this->dispatch('mes-cambiado'); // Emitir evento
    }
    
    public function mesSiguiente()
    {
        $this->fechaActual = Carbon::parse($this->fechaActual)->addMonth()->format('Y-m-d');
        $this->cargarPracticas();
        $this->dispatch('mes-cambiado'); // Emitir evento
    }
    
    public function actualizarFecha()
    {
        $this->mostrarDatepicker = false;
        $this->cargarPracticas();
    }
    
    public function seleccionarFecha($fecha)
    {
        $this->fechaSeleccionada = $fecha;
        
        $practica = Practica::where('user_id', Auth::id())
                            ->where('fecha', $fecha)
                            ->first();
        
        if($practica) {
            $this->actividad = $practica->actividad;
            $this->horas = $practica->horas;
            $this->observaciones = $practica->observaciones;
            $this->practicaExistente = true;
        } else {
            $this->reset(['actividad', 'horas', 'observaciones']);
            $this->practicaExistente = false;
        }
        
        $this->showModal = true;
    }
    
    public function guardarPractica()
{
    $this->validate();
    
    Practica::updateOrCreate(
        [
            'user_id' => Auth::id(),
            'fecha' => $this->fechaSeleccionada,
        ],
        [
            'actividad' => $this->actividad,
            'horas' => $this->horas,
            'observaciones' => $this->observaciones,
        ]
    );
    
    $this->showModal = false;
    $this->cargarPracticas(); // Actualizar prácticas inmediatamente
    $this->dispatch('practica-actualizada'); // Nuevo evento
    session()->flash('message', 'Práctica guardada correctamente');
}

public function eliminarPractica()
{
    Practica::where('user_id', Auth::id())
            ->where('fecha', $this->fechaSeleccionada)
            ->delete();
    
    $this->showModal = false;
    $this->cargarPracticas(); // Actualizar prácticas inmediatamente
    $this->dispatch('practica-actualizada'); // Nuevo evento
    session()->flash('message', 'Práctica eliminada correctamente');
}
    
    public function render()
    {
        return view('livewire.alumno.calendario-practicas');
    }
}