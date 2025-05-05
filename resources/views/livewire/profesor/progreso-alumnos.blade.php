<div class="space-y-6">
    <!-- Selectores de mes y año -->
    <div class="flex items-center space-x-4 bg-white p-4 rounded-lg shadow">
        <div class="flex items-center space-x-2">
            <span class="text-gray-700">Mes:</span>
            <select wire:model="mesSeleccionado" wire:change="cambiarMes($event.target.value)" 
                    class="border-gray-300 rounded-md shadow-sm">
                @foreach($meses as $numero => $nombre)
                    <option value="{{ $numero }}">{{ $nombre }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="flex items-center space-x-2">
            <span class="text-gray-700">Año:</span>
            <select wire:model="anoSeleccionado" wire:change="cambiarAno($event.target.value)" 
                    class="border-gray-300 rounded-md shadow-sm">
                @foreach($anos as $ano)
                    <option value="{{ $ano }}">{{ $ano }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Listado de alumnos con progreso -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-medium text-gray-900">Progreso de Alumnos</h3>
            <p class="mt-1 text-sm text-gray-500">
                {{ $meses[$mesSeleccionado] }} de {{ $anoSeleccionado }} - 
                {{ $totalDiasLectivos }} días lectivos
            </p>
        </div>
        
        <div class="divide-y divide-gray-200">
            @forelse($alumnos as $alumno)
                <div class="px-6 py-4">
                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <h4 class="font-medium text-gray-900">{{ $alumno->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $alumno->email }}</p>
                        </div>
                        <span class="text-sm font-medium {{ $alumno->progreso >= 80 ? 'text-green-600' : ($alumno->progreso >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                            {{ $alumno->progreso }}%
                        </span>
                    </div>
                    
                    <!-- Barra de progreso -->
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-600 h-2.5 rounded-full" 
                             style="width: {{ $alumno->progreso }}%"></div>
                    </div>
                    
                    <div class="flex justify-between mt-1">
                        <span class="text-xs text-gray-500">
                            {{ $alumno->diasRegistrados }} de {{ $alumno->totalDias }} días lectivos registrados
                        </span>
                        @if($alumno->practicas->count() > $alumno->diasRegistrados)
                            <span class="text-xs text-orange-500">
                                +{{ $alumno->practicas->count() - $alumno->diasRegistrados }} en fines de semana
                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="px-6 py-4 text-center text-gray-500">
                    No tienes alumnos asignados o no hay datos para el mes seleccionado
                </div>
            @endforelse
        </div>
    </div>
</div>