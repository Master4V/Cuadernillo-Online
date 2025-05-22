<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Información del Alumno
            </h2>
            <a href="{{ route('alumno.pdf') }}"
                class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-lg flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                </svg>
                Generar PDF
            </a>

        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @livewire('alumno.datos-grupo')
                </div>

                <div class="p-6 bg-white border-b border-gray-200">
                    @livewire('alumno.estadisticas-registros')
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
        <script>
            function generatePDF() {
                // Elemento que contiene todo el contenido
                const element = document.querySelector('.max-w-7xl');

                // Opciones para el PDF
                const opt = {
                    margin: 10,
                    filename: 'Cuadernillo de Practicas.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },
                    html2canvas: {
                        scale: 2
                    },
                    jsPDF: {
                        unit: 'mm',
                        format: 'a4',
                        orientation: 'portrait'
                    }
                };

                // Generar el PDF
                html2pdf().set(opt).from(element).save();
            }
        </script>
    @endpush
</x-app-layout>
