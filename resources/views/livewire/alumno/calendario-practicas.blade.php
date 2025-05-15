<div>
    @if(session('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="bg-white p-4 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4">Diario de Prácticas</h2>
        
        <!-- Controles de navegación -->
        <div class="flex items-center justify-between mb-4">
            <button wire:click="mesAnterior" class="p-2 rounded-full hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </button>
            
            <div class="flex items-center">
                @if($mostrarDatepicker)
                    <input type="date" 
                           wire:model="fechaActual"
                           wire:change="actualizarFecha"
                           class="border rounded p-2 text-center"
                           wire:blur="$set('mostrarDatepicker', false)">
                @else
                    <button wire:click="$set('mostrarDatepicker', true)" class="text-lg font-medium">
                        {{ \Carbon\Carbon::parse($fechaActual)->translatedFormat('F Y') }}
                    </button>
                @endif
            </div>
            
            <button wire:click="mesSiguiente" class="p-2 rounded-full hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
        
        <!-- Calendario -->
        <div class="grid grid-cols-7 gap-1 mb-4" wire:key="calendario-{{ $fechaActual }}-{{ time() }}">
            @foreach(['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'] as $day)
            <div class="text-center font-medium py-2">{{ $day }}</div>
            @endforeach
        
        @php
            $fecha = \Carbon\Carbon::parse($fechaActual);
            $startDay = $fecha->firstOfMonth()->dayOfWeekIso - 1;
            $daysInMonth = $fecha->daysInMonth;
            $today = now()->format('Y-m-d');
            $currentMonthYear = $fecha->format('Y-m');
        @endphp
        
        @for($i = 0; $i < $startDay; $i++)
            <div class="h-12 border"></div>
        @endfor
        
        @for($day = 1; $day <= $daysInMonth; $day++)
            @php
                $currentDate = $currentMonthYear . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
                $hasPractice = isset($practicas[$currentDate]);
                $isToday = $currentDate === $today;
                $dayClass = $hasPractice 
                    ? 'bg-green-100 border-green-300 hover:bg-green-200' 
                    : 'bg-white hover:bg-gray-50';
                $textClass = $hasPractice ? 'text-green-800 font-medium' : 'text-gray-700';
            @endphp
            
            <div 
                wire:click="seleccionarFecha('{{ $currentDate }}')"
                class="h-12 border p-1 cursor-pointer transition-colors relative
                       {{ $dayClass }}
                       {{ $isToday ? 'border-blue-500 border-2' : '' }}
                       {{ $fecha->format('Y-m') !== now()->format('Y-m') ? 'opacity-80' : '' }}"
            >
                <div class="flex justify-between {{ $textClass }}">
                    <span>{{ $day }}</span>
                    @if($hasPractice)
                        <span class="text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    @endif
                </div>
                @if($hasPractice)
                    <div class="text-xs truncate mt-1 {{ $textClass }}">
                        {{ Str::limit($practicas[$currentDate]->actividad, 15) }}
                    </div>
                @endif
            </div>
        @endfor
    </div>
    
    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-medium mb-4">
                    {{ $practicaExistente ? 'Editar práctica' : 'Registrar práctica' }} 
                    para {{ \Carbon\Carbon::parse($fechaSeleccionada)->format('d/m/Y') }}
                </h3>
                
                <form wire:submit.prevent="guardarPractica">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Actividad realizada</label>
                        <input type="text" wire:model="actividad" class="w-full px-3 py-2 border rounded">
                        @error('actividad') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="mb-4" x-data="{ mostrarCalculadora: false }">
                        <label class="block text-sm font-medium mb-1">Horas trabajadas</label>
                        <div class="flex gap-2">
                            <input 
                                type="number"
                                step="0.5"
                                min="0.5"
                                max="12"
                                wire:model="horas"
                                class="w-full px-3 py-2 border rounded"
                                placeholder="Ej: 4.5"
                                x-bind:readonly="mostrarCalculadora"
                                wire:key="horas-input-{{ now()->timestamp }}"
                            >
                            <button 
                                type="button" 
                                @click="mostrarCalculadora = !mostrarCalculadora"
                                class="px-3 py-2 border rounded hover:bg-gray-100"
                            >
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </button>
                        </div>
                        @error('horas') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    
                        <!-- Calculadora de horas -->
                        <div x-show="mostrarCalculadora" x-cloak class="mt-2 p-4 border rounded-lg bg-gray-50">
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Hora inicio</label>
                                    <input 
                                        type="time" 
                                        wire:model.live="hora_inicio"
                                        wire:change="calcularHoras"
                                        class="w-full px-3 py-2 border rounded text-sm"
                                    >
                                    @error('hora_inicio') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Hora fin</label>
                                    <input 
                                        type="time" 
                                        wire:model.live="hora_fin"
                                        wire:change="calcularHoras"
                                        class="w-full px-3 py-2 border rounded text-sm"
                                    >
                                    @error('hora_fin') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="flex justify-end gap-2">
                                <button 
                                    type="button" 
                                    @click="mostrarCalculadora = false" 
                                    class="px-3 py-1 text-sm text-gray-600 hover:bg-gray-100 rounded"
                                >
                                    Cancelar
                                </button>
                                <button 
                                    type="button" 
                                    wire:click="calcularHoras"
                                    @click="mostrarCalculadora = false"
                                    class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700"
                                >
                                    Calcular
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Observaciones</label>
                        <textarea wire:model="observaciones" rows="3" class="w-full px-3 py-2 border rounded"></textarea>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        @if($practicaExistente)
                            <button type="button" 
                                    wire:click="confirmarEliminacion"
                                    class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                Eliminar
                            </button>
                        @else
                            <div></div>
                        @endif
                        
                        <div class="flex space-x-2">
                            <button type="button" 
                                    wire:click="$set('showModal', false)" 
                                    class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded">
                                Cancelar
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                {{ $practicaExistente ? 'Actualizar' : 'Guardar' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            @if($showDeleteModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-sm">
            <h3 class="text-lg font-medium mb-4">¿Eliminar práctica?</h3>
            <p class="text-sm text-gray-600 mb-6">
                ¿Estás seguro de que deseas eliminar la práctica del día {{ \Carbon\Carbon::parse($fechaSeleccionada)->format('d/m/Y') }}? Esta acción no se puede deshacer.
            </p>
            <div class="flex justify-end gap-3">
                <button
                    wire:click="$set('showDeleteModal', false)"
                    class="px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded hover:bg-gray-200"
                >
                    Cancelar
                </button>
                <button
                    wire:click="eliminarPractica"
                    class="px-4 py-2 text-sm text-white bg-red-600 rounded hover:bg-red-700"
                >
                    Eliminar
                </button>
            </div>
        </div>
    </div>
@endif

        </div>
    @endif
</div>