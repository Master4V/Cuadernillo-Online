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
    public $hora_inicio;
    public $hora_fin;
    public $showDeleteModal = false;

    protected $rules = [
        'actividad' => 'required|min:3',
        'horas' => 'required|numeric|min:0.5|max:12',
        'observaciones' => 'nullable|string',
        'hora_inicio' => 'nullable|date_format:H:i',
        'hora_fin' => 'nullable|date_format:H:i|after:hora_inicio',
    ];

    public function mount()
    {
        $this->fechaActual = now()->format('Y-m');
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
        $this->dispatch('mes-cambiado');
    }

    public function mesSiguiente()
    {
        $this->fechaActual = Carbon::parse($this->fechaActual)->addMonth()->format('Y-m-d');
        $this->cargarPracticas();
        $this->dispatch('mes-cambiado');
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

        if ($practica) {
            $this->actividad = $practica->actividad;
            $this->horas = $practica->horas;
            $this->observaciones = $practica->observaciones;
            $this->hora_inicio = $practica->hora_inicio;
            $this->hora_fin = $practica->hora_fin;
            $this->practicaExistente = true;
        } else {
            $this->reset(['actividad', 'horas', 'observaciones', 'hora_inicio', 'hora_fin']);
            $this->practicaExistente = false;
        }

        $this->showModal = true;
    }

    public function calcularHoras()
    {
        $this->validate([
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i',
        ]);

        try {
            $inicio = Carbon::createFromFormat('H:i', $this->hora_inicio);
            $fin = Carbon::createFromFormat('H:i', $this->hora_fin);

            if ($fin->lessThan($inicio)) {
                $fin->addDay();
            }

            $diferenciaMinutos = $fin->diffInMinutes($inicio);
            $this->horas = round((abs($diferenciaMinutos) / 60) * 2) / 2;

            if ($this->horas > 12) {
                $this->horas = 12;
                $this->dispatch(
                    'notify',
                    message: 'Se ha limitado a 12 horas máximo por día.',
                    type: 'warning'
                );
            }

            $this->dispatch('horas-calculadas');
        } catch (\Exception $e) {
            $this->dispatch(
                'notify',
                message: 'Error al calcular las horas. Verifica el formato (HH:MM).',
                type: 'error'
            );
        }
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
                'hora_inicio' => $this->hora_inicio,
                'hora_fin' => $this->hora_fin,
            ]
        );

        $this->showModal = false;
        $this->cargarPracticas();
        $this->dispatch('practica-guardada');
        $this->dispatch(
            'notify',
            message: 'Práctica guardada correctamente',
            type: 'success'
        );
    }

    public function confirmarEliminacion()
    {
        $this->showDeleteModal = true;
    }

    public function eliminarPractica()
    {
        Practica::where('user_id', Auth::id())
            ->where('fecha', $this->fechaSeleccionada)
            ->delete();

        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->cargarPracticas();
        $this->dispatch('practica-actualizada');
        $this->dispatch(
            'notify',
            message: 'Práctica eliminada correctamente',
            type: 'success'
        );
    }

    public function render()
    {
        return view('livewire.alumno.calendario-practicas');
    }
}
