<div>
    <!-- Acordeón -->
    <div class="bg-white shadow-sm rounded-lg overflow-hidden mb-6">
        <button 
            wire:click="toggleAccordion"
            class="w-full px-6 py-4 text-left font-medium text-gray-900 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
            <div class="flex justify-between items-center">
                <span>Datos del Grupo y Prácticas</span>
                <svg 
                    class="w-5 h-5 transform transition-transform duration-200 {{ $expanded ? 'rotate-180' : '' }}" 
                    fill="none" 
                    stroke="currentColor" 
                    viewBox="0 0 24 24"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </button>
        
        <div class="px-6 py-4 transition-all duration-200 {{ $expanded ? 'block' : 'hidden' }}">
            @if($grupo)
                <!-- Información asignada por el profesor -->
                <div class="mb-6">
                    <h3 class="font-medium text-gray-900 mb-2">Información de Asignación</h3>
                    <p class="text-sm text-gray-600">
                        <span class="font-medium">Profesor asignado:</span> 
                        {{ $profesor->name ?? 'No asignado' }}
                    </p>
                </div>
                
                <!-- Datos editables - Solo visualización -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Columna 1 -->
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Profesor de prácticas</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $nombre_profesor_practicas ?: 'Pendiente de completar' }}</p>
                        </div>
                
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Grado que estudia</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $grado_estudiante ?: 'Pendiente de completar' }}</p>
                        </div>
                
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Curso académico</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $curso_academico ?: 'Pendiente de completar' }}</p>
                        </div>
                    </div>
                
                    <!-- Columna 2 -->
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Empresa de prácticas</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $empresa_practicas ?: 'Pendiente de completar' }}</p>
                        </div>
                
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Monitor de la empresa</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $monitor_empresa ?: 'Pendiente de completar' }}</p>
                        </div>
                    </div>
                </div>
                
                
                <!-- Botón para abrir modal -->
                <div class="mt-6">
                    <button 
                        wire:click="openModal"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        Editar Datos
                    </button>
                </div>
            @else
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <p class="text-yellow-700">No estás asignado a ningún grupo. Por favor, contacta con tu profesor.</p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Modal -->
    @if($isOpen)
        <div class="fixed inset-0 overflow-y-auto z-50">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Fondo oscuro -->
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                
                <!-- Centrar modal -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                
                <!-- Contenido del modal -->
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Editar Datos de Prácticas</h3>
                            <button 
                                wire:click="closeModal"
                                class="text-gray-400 hover:text-gray-500 focus:outline-none"
                            >
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        
                        <div class="mt-4">
                            <div class="grid grid-cols-1 gap-y-4">
                                <div>
                                    <label for="empresa_practicas" class="block text-sm font-medium text-gray-700">Empresa de prácticas</label>
                                    <input 
                                        wire:model="empresa_practicas" 
                                        type="text" 
                                        id="empresa_practicas" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    >
                                </div>
                                
                                <div>
                                    <label for="nombre_profesor_practicas" class="block text-sm font-medium text-gray-700">Nombre profesor de prácticas</label>
                                    <input 
                                        wire:model="nombre_profesor_practicas" 
                                        type="text" 
                                        id="nombre_profesor_practicas" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    >
                                </div>
                                
                                <div>
                                    <label for="monitor_empresa" class="block text-sm font-medium text-gray-700">Monitor de la empresa</label>
                                    <input 
                                        wire:model="monitor_empresa" 
                                        type="text" 
                                        id="monitor_empresa" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    >
                                </div>
                                
                                <div>
                                    <label for="grado_estudiante" class="block text-sm font-medium text-gray-700">Grado que estudia</label>
                                    <input 
                                        wire:model="grado_estudiante" 
                                        type="text" 
                                        id="grado_estudiante" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    >
                                </div>
                                
                                <div>
                                    <label for="curso_academico" class="block text-sm font-medium text-gray-700">Curso académico</label>
                                    <input 
                                        wire:model="curso_academico" 
                                        type="text" 
                                        id="curso_academico" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button 
                            wire:click="save"
                            type="button" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
                        >
                            Confirmar
                        </button>
                        <button 
                            wire:click="closeModal"
                            type="button" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        >
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Mensaje de éxito -->
    @if (session()->has('message'))
        <div 
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 3000)"
            class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg"
        >
            {{ session('message') }}
        </div>
    @endif
</div>