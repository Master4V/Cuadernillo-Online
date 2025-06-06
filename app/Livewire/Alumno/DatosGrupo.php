<?php

namespace App\Livewire\Alumno;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class DatosGrupo extends Component
{
    public $isOpen = false;
    public $expanded = false;

    public $centro_docente;
    public $nombre_profesor_practicas;
    public $empresa_practicas;
    public $tutor_empresa;
    public $periodo_realizacion;
    public $curso_academico;
    public $familia_profesional;
    public $ciclo;
    public $grado;
    public $showRAModal = false;


    protected $rules = [
        'centro_docente' => 'nullable|string|max:255',
        'nombre_profesor_practicas' => 'nullable|string|max:255',
        'empresa_practicas' => 'nullable|string|max:255',
        'tutor_empresa' => 'nullable|string|max:255',
        'periodo_realizacion' => 'nullable|string|max:255',
        'curso_academico' => 'nullable|string|max:255',
        'familia_profesional' => 'nullable|string|max:255',
        'ciclo' => 'nullable|string|max:255',
        'grado' => 'nullable|string|max:255'
    ];

    public $ciclosOptions = [];

    protected function getCiclosPorFamiliaYGrado()
    {
        return [
            'Actividades Físicas y Deportivas' => [
                'Medio' => [
                    'Guía en el Medio Natural y de Tiempo Libre',
                ],
                'Superior' => [
                    'Acondicionamiento Físico',
                    'Enseñanza y Animación Sociodeportiva',
                ],
            ],
            'Administración y Gestión' => [
                'Medio' => [
                    'Gestión Administrativa',
                ],
                'Superior' => [
                    'Administración y Finanzas',
                    'Asistencia a la Dirección',
                ],
            ],
            'Agraria' => [
                'Medio' => [
                    'Producción Agroecológica',
                    'Jardinería y Floristería',
                ],
                'Superior' => [
                    'Gestión Forestal y del Medio Natural',
                    'Paisajismo y Medio Rural',
                ],
            ],
            'Artes Gráficas' => [
                'Medio' => [
                    'Preimpresión Digital',
                    'Impresión Gráfica',
                ],
                'Superior' => [
                    'Diseño y Edición de Publicaciones Impresas y Multimedia',
                ],
            ],
            'Artes y Artesanías' => [
                'Medio' => [
                    'Reproducciones Artísticas en Madera',
                ],
                'Superior' => [
                    'Ebanistería Artística',
                ],
            ],
            'Comercio y Marketing' => [
                'Medio' => [
                    'Actividades Comerciales',
                ],
                'Superior' => [
                    'Gestión de Ventas y Espacios Comerciales',
                    'Marketing y Publicidad',
                    'Comercio Internacional',
                ],
            ],
            'Electricidad y Electrónica' => [
                'Medio' => [
                    'Instalaciones Eléctricas y Automáticas',
                ],
                'Superior' => [
                    'Sistemas Electrotécnicos y Automatizados',
                    'Sistemas de Telecomunicaciones e Informáticos',
                ],
            ],
            'Energía y Agua' => [
                'Medio' => [
                    'Redes y Estaciones de Tratamiento de Aguas',
                ],
                'Superior' => [
                    'Eficiencia Energética y Energía Solar Térmica',
                    'Energías Renovables',
                ],
            ],
            'Edificación y Obra Civil' => [
                'Medio' => [
                    'Construcción',
                ],
                'Superior' => [
                    'Proyectos de Edificación',
                    'Proyectos de Obra Civil',
                ],
            ],
            'Fabricación Mecánica' => [
                'Medio' => [
                    'Mecanizado',
                    'Soldadura y Calderería',
                ],
                'Superior' => [
                    'Construcciones Metálicas',
                    'Diseño en Fabricación Mecánica',
                ],
            ],
            'Hostelería y Turismo' => [
                'Medio' => [
                    'Cocina y Gastronomía',
                    'Servicios en Restauración',
                ],
                'Superior' => [
                    'Gestión de Alojamientos Turísticos',
                    'Dirección de Cocina',
                    'Agencias de Viajes y Gestión de Eventos',
                ],
            ],
            'Industrias Extractivas' => [
                'Medio' => [
                    'Excavaciones y Sondeos',
                ],
                'Superior' => [
                    'Minería',
                ],
            ],
            'Informática y Comunicaciones' => [
                'Medio' => [
                    'Sistemas Microinformáticos y Redes',
                ],
                'Superior' => [
                    'Desarrollo de Aplicaciones Multiplataforma',
                    'Desarrollo de Aplicaciones Web',
                    'Administración de Sistemas Informáticos en Red',
                ],
            ],
            'Instalación y Mantenimiento' => [
                'Medio' => [
                    'Instalaciones de Producción de Calor',
                    'Instalaciones Frigoríficas y de Climatización',
                ],
                'Superior' => [
                    'Mantenimiento de Instalaciones Térmicas y de Fluidos',
                ],
            ],
            'Imagen Personal' => [
                'Medio' => [
                    'Peluquería y Cosmética Capilar',
                    'Estética y Belleza',
                ],
                'Superior' => [
                    'Estética Integral y Bienestar',
                ],
            ],
            'Imagen y Sonido' => [
                'Medio' => [
                    'Vídeo Disc-Jockey y Sonido',
                ],
                'Superior' => [
                    'Realización de Proyectos Audiovisuales y Espectáculos',
                    'Sonido para Audiovisuales y Espectáculos',
                ],
            ],
            'Industrias Alimentarias' => [
                'Medio' => [
                    'Panadería, Repostería y Confitería',
                    'Elaboración de Productos Alimenticios',
                ],
                'Superior' => [
                    'Procesos y Calidad en la Industria Alimentaria',
                ],
            ],
            'Madera, Mueble y Corcho' => [
                'Medio' => [
                    'Carpintería y Mueble',
                ],
                'Superior' => [
                    'Diseño y Amueblamiento',
                ],
            ],
            'Marítimo-Pesquera' => [
                'Medio' => [
                    'Navegación y Pesca de Litoral',
                ],
                'Superior' => [
                    'Organización del Mantenimiento de Maquinaria de Buques y Embarcaciones',
                ],
            ],
            'Química' => [
                'Medio' => [
                    'Operaciones de Transformación de Plásticos y Caucho',
                ],
                'Superior' => [
                    'Laboratorio de Análisis y de Control de Calidad',
                    'Química Industrial',
                ],
            ],
            'Sanidad' => [
                'Medio' => [
                    'Cuidados Auxiliares de Enfermería',
                    'Farmacia y Parafarmacia',
                ],
                'Superior' => [
                    'Laboratorio Clínico y Biomédico',
                    'Imagen para el Diagnóstico y Medicina Nuclear',
                    'Radioterapia y Dosimetría',
                    'Higiene Bucodental',
                ],
            ],
            'Seguridad y Medio Ambiente' => [
                'Medio' => [
                    'Emergencias y Protección Civil',
                ],
                'Superior' => [
                    'Prevención de Riesgos Profesionales',
                    'Educación y Control Ambiental',
                ],
            ],
            'Servicios Socioculturales y a la Comunidad' => [
                'Medio' => [
                    'Atención a Personas en Situación de Dependencia',
                ],
                'Superior' => [
                    'Educación Infantil',
                    'Integración Social',
                ],
            ],
            'Textil, Confección y Piel' => [
                'Medio' => [
                    'Confección y Moda',
                ],
                'Superior' => [
                    'Patronaje y Moda',
                ],
            ],
            'Transporte y Mantenimiento de Vehículos' => [
                'Medio' => [
                    'Electromecánica de Vehículos Automóviles',
                    'Carrocería',
                ],
                'Superior' => [
                    'Automoción',
                ],
            ],
            'Vidrio y Cerámica' => [
                'Medio' => [
                    'Fabricación de Productos Cerámicos',
                ],
                'Superior' => [
                    'Desarrollo de Productos Cerámicos',
                ],
            ],
        ];
    }

    public function mount()
    {
        $this->loadGrupoData();
        $this->updateCiclosOptions();
    }

    public function updated($propertyName)
    {
        // Actualización reactiva inmediata
        if (in_array($propertyName, ['familia_profesional', 'grado'])) {
            $this->updateCiclosOptions();
        }
    }

    protected function updateCiclosOptions()
    {
        $this->ciclosOptions = [];

        if ($this->familia_profesional && $this->grado) {
            $familias = $this->getCiclosPorFamiliaYGrado();

            if (isset($familias[$this->familia_profesional][$this->grado])) {
                $this->ciclosOptions = $familias[$this->familia_profesional][$this->grado];

                if (!in_array($this->ciclo, $this->ciclosOptions)) {
                    $this->ciclo = null;
                }
            }
        }
    }

    public function loadGrupoData()
    {
        $grupo = Auth::user()->grupoComoAlumno;

        if ($grupo) {
            $this->centro_docente = $grupo->centro_docente;
            //$this->nombre_profesor_practicas = $grupo->nombre_profesor_practicas;
            $this->empresa_practicas = $grupo->empresa_practicas;
            $this->tutor_empresa = $grupo->tutor_empresa;
            $this->periodo_realizacion = $grupo->periodo_realizacion;
            $this->curso_academico = $grupo->curso_academico;
            $this->familia_profesional = $grupo->familia_profesional;
            $this->ciclo = $grupo->ciclo;
            $this->grado = $grupo->grado;

            if (empty($this->nombre_profesor_practicas)) {
                $this->nombre_profesor_practicas = $grupo->profesor?->name;
            }
        }
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->loadGrupoData();
    }
    public function toggleAccordion()
    {
        $this->expanded = !$this->expanded;
    }

    public function save()
    {
        $this->validate();

        $grupo = Auth::user()->grupoComoAlumno;

        if ($grupo) {
            $grupo->update($this->only([
                'centro_docente',
                'nombre_profesor_practicas',
                'empresa_practicas',
                'tutor_empresa',
                'periodo_realizacion',
                'curso_academico',
                'familia_profesional',
                'ciclo',
                'grado'
            ]));

            $this->closeModal();
            session()->flash('message', 'Datos actualizados correctamente');
        }
    }

    public function openRAModal()
    {
        $this->showRAModal = true;
    }

    public function closeRAModal()
    {
        $this->showRAModal = false;
    }

    public function render()
    {
        $grupo = Auth::user()->grupoComoAlumno;
        $profesor = $grupo ? $grupo->profesor : null;
        $alumno = Auth::user();

        return view('livewire.alumno.datos-grupo', [
            'grupo' => $grupo,
            'profesor' => $profesor,
            'alumno' => $alumno
        ]);
    }
}
/*
<!-- Modal Edit -->
    @if ($isOpen)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 overflow-y-hidden">
            <div class="bg-white rounded-lg w-full max-w-4xl mx-auto my-8 flex flex-col" style="max-height: 90vh;">
                <!-- Cabecera del modal -->
                <div class="flex justify-between items-center p-6 border-b sticky top-0 bg-white z-10">
                    <h3 class="text-xl font-semibold">Editar Datos Completo</h3>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700 text-2xl">
                        &times;
                    </button>
                </div>

                <!-- Contenido con scroll -->
                <div class="p-6 overflow-y-auto flex-grow">
                    <!-- Sección Centro Educativo >
                    <div class="bg-blue-50 p-4 rounded-lg mb-6">
                        <h4 class="font-medium text-blue-800 mb-4">Centro Educativo</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Centro docente</label>
                                <input wire:model="centro_docente" type="text"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Profesor responsable</label>
                                <input wire:model="nombre_profesor_practicas" type="text"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" readonly>
                            </div>
                        </div>
                    </div-->

                    <!-- Sección Empresa -->
                    <div class="bg-green-50 p-4 rounded-lg mb-6">
                        <h4 class="font-medium text-green-800 mb-4">Empresa</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!--div>
                                <label class="block text-sm font-medium mb-1">Empresa</label>
                                <input wire:model="empresa_practicas" type="text"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Tutor empresa</label>
                                <input wire:model="tutor_empresa" type="text"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" readonly>
                            </div-->
                            <div>
                                <label class="block text-sm font-medium mb-1">Periodo FCT</label>
                                <select wire:model="periodo_realizacion"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">--Seleccione una opción--</option>
                                    <option value="Primer Trimestre">Primer Trimestre</option>
                                    <option value="Segundo Trimestre">Segundo Trimestre</option>
                                    <option value="Tercer Trimestre">Tercer Trimestre</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Sección Datos Académicos -->
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <h4 class="font-medium text-purple-800 mb-4">Datos Académicos</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Curso escolar</label>
                                <input type="text" wire:model="curso_academico" placeholder="2024/2025"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    pattern="\d{4}/\d{4}">
                            </div>

                            <!-- Selector de Familia Profesional -->
                            <div>
                                <label class="block text-sm font-medium mb-1">Familia profesional</label>
                                <select wire:model.live="familia_profesional"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">-- Seleccione familia --</option>
                                    @foreach (['Actividades Físicas y Deportivas', 'Administración y Gestión', 'Agraria', 'Artes Gráficas', 'Artes y Artesanías', 'Comercio y Marketing', 'Edificación y Obra Civil', 'Electricidad y Electrónica', 'Energía y Agua', 'Fabricación Mecánica', 'Hostelería y Turismo', 'Imagen Personal', 'Imagen y Sonido', 'Industrias Alimentarias', 'Industrias Extractivas', 'Informática y Comunicaciones', 'Instalación y Mantenimiento', 'Madera, Mueble y Corcho', 'Marítimo-Pesquera', 'Química', 'Sanidad', 'Seguridad y Medio Ambiente', 'Servicios Socioculturales y a la Comunidad', 'Textil, Confección y Piel', 'Transporte y Mantenimiento de Vehículos', 'Vidrio y Cerámica'] as $familia)
                                        <option value="{{ $familia }}">{{ $familia }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Selector de Grado -->
                            <div>
                                <label class="block text-sm font-medium mb-1">Grado</label>
                                <select wire:model.live="grado"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">-- Seleccione grado --</option>
                                    <option value="Medio">Grado Medio</option>
                                    <option value="Superior">Grado Superior</option>
                                </select>
                            </div>

                            <!-- Selector de Ciclo -->
                            <div>
                                <label class="block text-sm font-medium mb-1">Ciclo</label>
                                <select wire:model="ciclo"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    wire:key="ciclo-{{ $familia_profesional }}-{{ $grado }}"
                                    @disabled(!count($ciclosOptions))>
                                    <option value="">-- Seleccione ciclo --</option>
                                    @foreach ($ciclosOptions as $cicloOption)
                                        <option value="{{ $cicloOption }}">{{ $cicloOption }}</option>
                                    @endforeach
                                    @if ($familia_profesional && $grado && !count($ciclosOptions))
                                        <option disabled>No hay ciclos disponibles</option>
                                    @endif
                                </select>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Botones fijos en la parte inferior -->
                <div class="p-4 border-t bg-white sticky bottom-0 flex justify-end gap-3">
                    <button wire:click="save"
                        class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Guardar Cambios
                    </button>
                    <button wire:click="closeModal"
                        class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    @endif
*/