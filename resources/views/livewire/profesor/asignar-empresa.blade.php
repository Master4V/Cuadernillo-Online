
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Gestión de Grupos de Prácticas</h2>
        <button 
            wire:click="$set('showCreateModal', true)" 
            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded"
        >
            + Nuevo Grupo
        </button>
    </div>

    <!-- Mensajes de éxito/error -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabla de grupos -->
    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left">Alumno</th>
                    <th class="px-6 py-3 text-left">Tutor Académico</th>
                    <th class="px-6 py-3 text-left">Empresa</th>
                    <th class="px-6 py-3 text-left">Tutor Empresa</th>
                    <th class="px-6 py-3 text-left">Dirección</th>
                    <th class="px-6 py-3 text-left">Teléfono</th>
                    <th class="px-6 py-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($grupos as $grupo)
                <tr wire:key="grupo-{{ $grupo->id }}">
                    <td class="px-6 py-4">{{ $grupo->alumno->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4">{{ $grupo->profesor->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4">{{ $grupo->empresa->nombre ?? 'Sin asignar' }}</td>
                    <td class="px-6 py-4">{{ $grupo->empresa->tutor ?? 'N/A' }}</td>
                    <td class="px-6 py-4">{{ $grupo->empresa->direccion ?? 'N/A' }}</td>
                    <td class="px-6 py-4">{{ $grupo->empresa->telefono ?? 'N/A' }}</td>
                    <!-- En la sección de acciones de la tabla (Blade) -->
<td class="px-6 py-4 space-x-2">
    <!-- Botón Editar -->
    <button 
        wire:click="editarGrupo({{ $grupo->id }})" 
        class="text-blue-500 hover:text-blue-700"
        title="Editar"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
        </svg>
    </button>
    
    <!-- Botón Eliminar -->
    <button 
        wire:click="confirmarEliminar({{ $grupo->id }})" 
        class="text-red-500 hover:text-red-700"
        title="Eliminar"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
    </button>
</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        No hay grupos registrados
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Crear Grupo -->
    @if($showCreateModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg p-6 w-full max-w-2xl">
<h3 class="text-xl font-bold mb-4">
    {{ $isEditing ? 'Editar Grupo' : 'Crear Nuevo Grupo' }}
</h3>                
                <form wire:submit.prevent="crearGrupo">
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Selección de Empresa -->
                        <div class="col-span-2">
                            <label class="block font-medium mb-1">Empresa*</label>
                            <select wire:model="nuevoGrupo.empresa_id"
    class="w-full border rounded p-2"
>
    <option value="">Seleccionar empresa...</option>
    @foreach($empresas as $empresa)
        <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
    @endforeach
</select>
                            @error('nuevoGrupo.empresa_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Selección de Profesor -->
                        <div>
                            <label class="block font-medium mb-1">Tutor Académico*</label>
                            <select 
                                wire:model="nuevoGrupo.profesor_id" 
                                class="w-full border rounded p-2"
                            >
                                <option value="">Seleccionar tutor...</option>
                                @foreach($profesores as $profesor)
                                    <option value="{{ $profesor->id }}">
                                        {{ $profesor->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('nuevoGrupo.profesor_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Selección de Alumno -->
                        <div>
                            <label class="block font-medium mb-1">Alumno*</label>
                            <select 
                                wire:model="nuevoGrupo.alumno_id" 
                                class="w-full border rounded p-2"
                            >
                                <option value="">Seleccionar alumno...</option>
                                @foreach($alumnos as $alumno)
                                    <option value="{{ $alumno->id }}">
                                        {{ $alumno->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('nuevoGrupo.alumno_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Campos fijos -->
                        <div class="col-span-2">
                            <label class="block font-medium mb-1">Centro Docente</label>
                            <input 
                                type="text" 
                                wire:model="nuevoGrupo.centro_docente" 
                                class="w-full border rounded p-2 bg-gray-100" 
                            >
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                       <button 
    type="button"
    wire:click="cerrarModal"
    class="px-4 py-2 border rounded hover:bg-gray-100"
>
    Cancelar
</button>
                        <button 
                            type="submit" 
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                        >
                            Guardar Grupo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Modal Eliminar -->
    @if($showDeleteModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-xl font-bold mb-4">Confirmar Eliminación</h3>
                <p class="mb-6">¿Estás seguro de eliminar el grupo de <strong>{{ $grupoToDelete->alumno->name ?? '' }}</strong>?</p>
                
                <div class="flex justify-end space-x-3">
                    <button 
                        wire:click="$set('showDeleteModal', false)" 
                        class="px-4 py-2 border rounded hover:bg-gray-100"
                    >
                        Cancelar
                    </button>
                    <button 
                        wire:click="eliminarGrupo" 
                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
                    >
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>