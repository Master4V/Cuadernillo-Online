<div>
    <div class="flex justify-between items-center mb-4">
        <div>
            <h3 class="text-lg font-medium">Gestión de Alumnos</h3>
            <p class="text-sm text-gray-500">
                {{ $showAsignados ? 'Alumnos en tu grupo' : 'Alumnos disponibles' }}
                ({{ $totalAsignados }} asignados)
            </p>
        </div>
        
        <button wire:click="toggleVista" class="px-4 py-2 bg-blue-100 text-blue-800 rounded-lg text-sm">
            {{ $showAsignados ? 'Ver disponibles' : 'Ver asignados' }}
        </button>
    </div>

    <div class="mb-4">
        <input 
            type="text" 
            wire:model.debounce.300ms="search"
            placeholder="Buscar alumnos..." 
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
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
                    <tr wire:key="alumno-{{ $alumno->id }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $alumno->name }}</div>
                            <div class="text-sm text-gray-500">{{ $alumno->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button 
                                wire:click="toggleAsignacion({{ $alumno->id }})"
                                class="{{ $showAsignados ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }} px-3 py-1 rounded text-sm"
                            >
                                {{ $showAsignados ? 'Quitar' : 'Asignar' }}
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">
                            No hay alumnos {{ $showAsignados ? 'en tu grupo' : 'disponibles' }}
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
            alert(data.message);
        });
    });
</script>

@endpush