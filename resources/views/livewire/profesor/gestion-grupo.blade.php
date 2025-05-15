<div>
    <!-- Modal de confirmación -->
    @if($mostrarModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                <div class="flex items-center mb-4">
                    <svg class="h-6 w-6 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900">Confirmar acción</h3>
                </div>
                <p class="text-gray-600 mb-6">
¿Estás seguro de que deseas quitar a <span class="font-semibold">{{ $nombreAlumnoParaQuitar }}</span> de tu grupo?
                </p>
                <div class="flex justify-end space-x-3">
                    <button 
                        wire:click="$set('mostrarModal', false)" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-150"
                    >
                        Cancelar
                    </button>
                    <button 
                        wire:click="quitarAlumno" 
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-150"
                    >
                        Sí, quitar alumno
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="flex justify-between items-center mb-4">
        <div>
            <h3 class="text-lg font-medium">Gestión de Alumnos</h3>
            <p class="text-sm text-gray-500">
                {{ $showAsignados ? 'Alumnos en tu grupo' : 'Alumnos disponibles' }}
                ({{ $totalAsignados }} asignados)
            </p>
        </div>
        
        <button wire:click="toggleVista" class="px-4 py-2 bg-blue-100 text-blue-800 rounded-lg text-sm hover:bg-blue-200 transition duration-150">
            {{ $showAsignados ? 'Ver disponibles' : 'Ver asignados' }}
        </button>
    </div>

    <div class="mb-4">
        <input 
            type="text" 
            wire:model="search"
            wire:keydown.debounce.300ms="searchUpdated"
            placeholder="Buscar alumnos..." 
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
        >
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alumno</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acción</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($alumnos as $alumno)
                    <tr wire:key="alumno-{{ $alumno->id }}" class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $alumno->name }}</div>
                            <div class="text-sm text-gray-500">{{ $alumno->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            @if(!$showAsignados)
                                <button 
                                    wire:click="toggleAsignacion({{ $alumno->id }})"
                                    class="bg-green-100 text-green-800 px-4 py-2 rounded-md text-sm hover:bg-green-200 transition duration-150 flex items-center"
                                >
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Asignar
                                </button>
                            @else
                                <button 
                                    wire:click="confirmarQuitar({{ $alumno->id }})"
                                    class="bg-red-100 text-red-800 px-4 py-2 rounded-md text-sm hover:bg-red-200 transition duration-150 flex items-center"
                                >
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Quitar
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">
                            <div class="flex flex-col items-center justify-center py-8">
                                <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span class="mt-2">No hay alumnos {{ $showAsignados ? 'en tu grupo' : 'disponibles' }}</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $alumnos->links('vendor.livewire.custom-pagination') }}
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:load', function() {
        Livewire.on('notify', data => {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 px-4 py-2 rounded-md shadow-lg text-white flex items-center ${
                data.type === 'success' ? 'bg-green-500' : 'bg-red-500'
            }`;
            
            const icon = document.createElement('svg');
            icon.className = 'w-5 h-5 mr-2';
            icon.fill = 'none';
            icon.viewBox = '0 0 24 24';
            icon.stroke = 'currentColor';
            
            const path = document.createElement('path');
            path.strokeLinecap = 'round';
            path.strokeLinejoin = 'round';
            path.strokeWidth = '2';
            path.d = data.type === 'success' 
                ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' 
                : 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z';
            
            icon.appendChild(path);
            toast.appendChild(icon);
            toast.appendChild(document.createTextNode(data.message));
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.add('opacity-0', 'transition', 'duration-300');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        });
    });
</script>
@endpush