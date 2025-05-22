<div class="bg-white shadow-sm rounded-lg overflow-hidden mb-6">
    <button wire:click="toggleAccordion"
        class="w-full px-6 py-4 text-left font-medium bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <div class="flex justify-between items-center">
            <span>Estadísticas de Registros</span>
            <svg class="w-5 h-5 transform transition-transform duration-200 {{ $expanded ? 'rotate-180' : '' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </button>

    <div class="px-6 py-4 transition-all duration-200 {{ $expanded ? 'block' : 'hidden' }}">

        <!-- Selector de Mes -->
        <div class="mb-6">
            <label for="mesSelector" class="block text-sm font-medium text-gray-700 mb-1">Seleccionar Mes</label>
            <select wire:model.live="mesSeleccionado" id="mesSelector"
                class="block w-full pl-3 pr-10 py-2 border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                @foreach ($mesesDisponibles as $value => $mes)
                    <option value="{{ $value }}">{{ $mes }}</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6"wire:key="estadisticas-{{ $mesSeleccionado }}">
            <!-- Progreso del Mes -->
            <div class="bg-blue-50 p-4 rounded-lg">
                <h3 class="font-medium text-blue-800 mb-2">Progreso del Mes</h3>
                <div class="w-full bg-gray-200 rounded-full h-4 mb-2">
                    <div class="bg-blue-600 h-4 rounded-full" style="width: {{ $porcentajeCompletado }}%"></div>
                </div>
                <p class="text-sm text-blue-700">{{ $porcentajeCompletado }}% completado ({{ $diasRegistrados }} de
                    {{ $diasLectivos }} días lectivos)</p>
                <p class="text-xs text-gray-500 mt-1">* Excluyendo fines de semana</p>
            </div>

            <!-- Último Registro -->
            <div class="bg-green-50 p-4 rounded-lg">
                <h3 class="font-medium text-green-800 mb-2">Último Registro</h3>
                @if ($ultimoRegistro)
                    <p class="text-sm text-green-700">
                        <span class="font-medium">Fecha:</span>
                        {{ \Carbon\Carbon::parse($ultimoRegistro->fecha)->format('d/m/Y') }}
                        ({{ \Carbon\Carbon::parse($ultimoRegistro->fecha)->isoFormat('dddd') }})
                    </p>
                    <p class="text-sm text-green-700"><span class="font-medium">Horas:</span>
                        {{ $ultimoRegistro->horas }}</p>
                @else
                    <p class="text-sm text-green-700">No hay registros para este mes.</p>
                @endif
            </div>
        </div>

        <!-- Detalle por Semanas -->
        <div class="mt-6">
            <h4 class="font-medium text-gray-900 mb-3">Detalle por Semanas</h4>
            <div class="space-y-4">
                @foreach ($semanas as $semana)
                    <div
                        class="{{ $semana['esSemanaActual'] ? 'bg-yellow-50 border-l-4 border-yellow-400' : 'bg-gray-50' }} p-3 rounded">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium">
                                Semana {{ $semana['numero'] }} ({{ $semana['inicio_formatted'] }} -
                                {{ $semana['fin_formatted'] }})
                                @if ($semana['esSemanaDividida'])
                                    <span class="text-xs text-gray-500 ml-1">(semana dividida)</span>
                                @endif
                            </span>
                            <span
                                class="text-xs px-2 py-1 rounded-full 
                                {{ $semana['dias_registrados'] === $semana['dias_lectivos']
                                    ? 'bg-green-100 text-green-800'
                                    : ($semana['dias_registrados'] > 0
                                        ? 'bg-blue-100 text-blue-800'
                                        : 'bg-gray-100 text-gray-800') }}">
                                {{ $semana['dias_registrados'] }}/{{ $semana['dias_lectivos'] }} días
                            </span>
                        </div>
                        @if ($semana['esSemanaActual'])
                            <p class="text-xs text-yellow-700 mt-1">Esta es la semana actual</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
