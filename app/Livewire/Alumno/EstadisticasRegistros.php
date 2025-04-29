<?php
namespace App\Livewire\Alumno;

use Livewire\Component;
use App\Models\Practica;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EstadisticasRegistros extends Component
{
    public $expanded = false;
    public $mesesDisponibles = [];
    public $mesSeleccionado;
    public $semanas = [];
    public $diasLectivos;
    public $diasRegistrados;
    public $diasFaltantes;
    public $porcentajeCompletado;
    public $ultimoRegistro;

    protected $listeners = ['registroActualizado' => 'actualizarTodo'];

    public function mount()
    {
        // Establecer el idioma de Carbon en español
        Carbon::setLocale('es');
        $this->cargarMesesDisponibles();
        $this->mesSeleccionado = Carbon::now()->format('Y-m');
        $this->actualizarTodo();
    }

    public function cargarMesesDisponibles()
    {
        $this->mesesDisponibles = Practica::where('user_id', Auth::id())
            ->whereNull('deleted_at')
            ->selectRaw('DISTINCT DATE_FORMAT(fecha, "%Y-%m") as mes')
            ->orderBy('mes', 'desc')
            ->pluck('mes')
            ->mapWithKeys(function ($item) {
                $date = Carbon::createFromFormat('Y-m', $item);
                return [
                    $item => ucfirst($date->translatedFormat('F Y'))  // Aquí se usa el formato traducido
                ];
            })
            ->toArray();
    }

    public function updatedMesSeleccionado(){
        $this->actualizarTodo();
    }

    public function actualizarTodo()
    {
        $this->calcularEstadisticas();
        $this->generarSemanas();
    }

    public function calcularEstadisticas()
    {
        $userId = Auth::id();
        $fecha = Carbon::createFromFormat('Y-m', $this->mesSeleccionado);
        $inicioMes = $fecha->copy()->startOfMonth();
        $finMes = $fecha->copy()->endOfMonth();

        $this->diasLectivos = $this->calcularDiasLectivos($inicioMes, $finMes);

        $this->diasRegistrados = Practica::where('user_id', $userId)
            ->whereNull('deleted_at')
            ->whereBetween('fecha', [$inicioMes, $finMes])
            ->whereRaw('DAYOFWEEK(fecha) NOT IN (1,7)')  // Excluir fines de semana
            ->distinct('fecha')
            ->count('fecha');

        $this->diasFaltantes = $this->diasLectivos - $this->diasRegistrados;

        $this->porcentajeCompletado = $this->diasLectivos > 0
            ? round(($this->diasRegistrados / $this->diasLectivos) * 100)
            : 0;

        $this->ultimoRegistro = Practica::where('user_id', $userId)
            ->whereNull('deleted_at')
            ->whereBetween('fecha', [$inicioMes, $finMes])
            ->latest('fecha')
            ->first();
    }

    protected function calcularDiasLectivos($inicio, $fin)
    {
        $dias = 0;
        $dia = $inicio->copy();

        while ($dia <= $fin) {
            if (!$dia->isWeekend()) {
                $dias++;
            }
            $dia->addDay();
        }

        return $dias;
    }

    public function generarSemanas()
    {
        $this->semanas = [];

        $fechaInicio = Carbon::createFromFormat('Y-m', $this->mesSeleccionado)->startOfMonth();
        $fechaFin = Carbon::createFromFormat('Y-m', $this->mesSeleccionado)->endOfMonth();
        $hoy = now();

        $inicioSemana = $fechaInicio->copy()->startOfWeek(Carbon::MONDAY);
        $finSemana = $inicioSemana->copy()->endOfWeek(Carbon::SUNDAY);

        $numeroSemana = 1;

        while ($inicioSemana->lte($fechaFin)) {
            // Semana solo válida si empieza o termina dentro del mes seleccionado
            if ($finSemana->lt($fechaInicio)) {
                $inicioSemana->addWeek();
                $finSemana = $inicioSemana->copy()->endOfWeek();
                continue;
            }

            $this->semanas[] = [
                'numero' => $numeroSemana++,
                'inicio' => $inicioSemana->copy(),
                'fin' => $finSemana->copy(),
                'esSemanaActual' => $hoy->between($inicioSemana, $finSemana) && $hoy->format('Y-m') === $fechaInicio->format('Y-m'),
            ];

            $inicioSemana->addWeek();
            $finSemana = $inicioSemana->copy()->endOfWeek();
        }
    }

    public function toggleAccordion()
    {
        $this->expanded = !$this->expanded;
    }

    public function render()
    {
        return view('livewire.alumno.estadisticas-registros');
    }
}
