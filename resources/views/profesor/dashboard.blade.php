


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel del Profesor
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Contenedor principal con scroll horizontal en móvil -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Versión móvil (columnas apiladas) -->
                    <div class="block sm:hidden space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Progreso de Alumnos</h3>
                            <div class="overflow-x-auto">
                                <div class="w-full min-w-max">
                                    <livewire:profesor.progreso-alumnos />
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Gestión de Grupo</h3>
                            <livewire:profesor.gestion-grupo />
                        </div>
                    </div>

                    <!-- Versión desktop (columnas lado a lado) -->
                    <div class="hidden sm:flex space-x-4">
                        <!-- Columna principal (Progreso de Alumnos) -->
                        <div class="flex-1" style="flex: 0 0 70%;">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Progreso de Alumnos</h3>
                            <livewire:profesor.progreso-alumnos />
                        </div>

                        <!-- Columna secundaria (Gestión de Grupo) -->
                        <div class="w-1/3" style="flex: 0 0 30%;">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Gestión de Grupo</h3>
                            <livewire:profesor.gestion-grupo />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>