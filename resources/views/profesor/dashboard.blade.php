<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel del Profesor
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Contenedor principal simplificado -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Título principal -->
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Progreso de Alumnos</h2>
                    
                    <!-- Versión móvil -->
                    <div class="block sm:hidden">
                        <div class="overflow-x-auto">
                            <div class="w-full min-w-max">
                                <livewire:profesor.progreso-alumnos />
                            </div>
                        </div>
                    </div>

                    <!-- Versión desktop -->
                    <div class="hidden sm:block">
                        <livewire:profesor.progreso-alumnos :key="'progreso-' . now()->timestamp" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>