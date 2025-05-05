<?php

namespace App\Livewire\Alumno;

use Livewire\Component;
use App\Models\Grupo;
use Illuminate\Support\Facades\Auth;

class DatosGrupo extends Component
{
    public $isOpen = false;
    public $expanded = false;

    // Campos actualizados
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

    public $ciclosOptions = []; // Nueva propiedad para opciones de ciclo

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
        $this->updateCiclosOptions(); // Cargar ciclos iniciales si existen datos
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
            $this->nombre_profesor_practicas = $grupo->nombre_profesor_practicas;
            $this->empresa_practicas = $grupo->empresa_practicas;
            $this->tutor_empresa = $grupo->tutor_empresa;
            $this->periodo_realizacion = $grupo->periodo_realizacion;
            $this->curso_academico = $grupo->curso_academico;
            $this->familia_profesional = $grupo->familia_profesional;
            $this->ciclo = $grupo->ciclo;
            $this->grado = $grupo->grado;
        }
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->loadGrupoData(); // Recarga los datos originales al cancelar
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
