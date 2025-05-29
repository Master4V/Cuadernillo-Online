<?php

namespace App\Livewire\Profesor;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Grupo;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Validation\Rule;

class AsignarEmpresa extends Component
{
    use WithPagination;

    public $grupos;
    public $empresas;
    public $profesores;
    public $alumnos;
    public $familia_profesional;
    public $ciclo;
    public $grado;

    // Campos para nuevo grupo
    public $showCreateModal = false;
    public $nuevoGrupo = [
        'empresa_id' => '',
        'profesor_id' => '',
        'alumno_id' => '',
        'centro_docente' => 'IES La Marisma',
        'tutor_empresa' => '',
        'periodo_realizacion' => '',
        'curso_academico' => '2024/2025',
        'familia_profesional' => '',
        'ciclo' => '',
        'grado' => ''
    ];
    public $ciclosOptions = [];

    //Campos editar
    public $isEditing = false;
    public $grupoEditId = null;

    // Campos para eliminar
    public $showDeleteModal = false;
    public $grupoToDelete;

    //Campos CRUDs
    public $showEmpresasModal = false;
    public $showAlumnosModal = false;

    public $search = '';

    protected $listeners = ['registroGuardado' => 'actualizarDatos'];

    public function actualizarDatos()
    {
        $this->empresas = Empresa::all();
        $this->loadAlumnosDisponibles();
    }

    public function mount()
    {
        $this->loadData();
        $this->loadAlumnosDisponibles();
        $this->profesores = User::where('role', 'profesor')->get();
        $this->empresas = Empresa::all();
    }


    public function loadData()
    {
        $this->grupos = Grupo::with(['alumno', 'profesor', 'empresa'])
            ->when($this->search, function ($query) {
                $query->whereHas('alumno', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                    ->orWhereHas('profesor', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('empresa', function ($q) {
                        $q->where('nombre', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->fresh();
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['nuevoGrupo.familia_profesional', 'nuevoGrupo.grado'])) {
            $this->updateCiclosOptions();

            if (!$this->isEditing) {
                $this->nuevoGrupo['ciclo'] = null;
            }
        }
    }



    protected function updateCiclosOptions()
    {
        $this->ciclosOptions = [];

        $familia = $this->nuevoGrupo['familia_profesional'] ?? null;
        $grado = $this->nuevoGrupo['grado'] ?? null;

        if ($familia && $grado) {
            $familias = $this->getCiclosPorFamiliaYGrado();

            if (isset($familias[$familia][$grado])) {
                $this->ciclosOptions = $familias[$familia][$grado];

                if (!in_array($this->nuevoGrupo['ciclo'], $this->ciclosOptions)) {
                    $this->nuevoGrupo['ciclo'] = null;
                }
            }
        }
    }


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

    public function updatedSearch($value)
    {
        $this->loadData();
    }

    public function crearGrupo()
    {
        $rules = [
            'nuevoGrupo.empresa_id' => 'required|exists:empresas,id',
            'nuevoGrupo.profesor_id' => 'required|exists:users,id',
            'nuevoGrupo.centro_docente' => 'required|string',
            'nuevoGrupo.tutor_empresa' => 'required|string',
            'nuevoGrupo.alumno_id' => [
                'required',
                'exists:users,id',
                Rule::unique('grupos', 'alumno_id')->ignore($this->grupoEditId)->whereNull('deleted_at'),
            ],
            'nuevoGrupo.periodo_realizacion' => 'required|string',
            'nuevoGrupo.curso_academico' => 'required|string',
            'nuevoGrupo.familia_profesional' => 'required|string',
            'nuevoGrupo.ciclo' => 'required|string',
            'nuevoGrupo.grado' => 'required|string',
        ];

        $this->validate($rules);

        $empresa = Empresa::find($this->nuevoGrupo['empresa_id']);
        $profesor = User::find($this->nuevoGrupo['profesor_id']);

        $data = [
            'empresa_id' => $this->nuevoGrupo['empresa_id'],
            'profesor_id' => $this->nuevoGrupo['profesor_id'],
            'alumno_id' => $this->nuevoGrupo['alumno_id'],
            'centro_docente' => $this->nuevoGrupo['centro_docente'],
            'tutor_empresa' => $this->nuevoGrupo['tutor_empresa'],
            'empresa_practicas' => $empresa?->nombre ?? '',
            'nombre_profesor_practicas' => $profesor?->name ?? '',
            'periodo_realizacion' => $this->nuevoGrupo['periodo_realizacion'],
            'curso_academico' => $this->nuevoGrupo['curso_academico'],
            'familia_profesional' => $this->nuevoGrupo['familia_profesional'],
            'grado' => $this->nuevoGrupo['grado'],
            'ciclo' => $this->nuevoGrupo['ciclo'],
        ];

        if ($this->isEditing) {
            Grupo::find($this->grupoEditId)->update($data);
            $message = 'Grupo actualizado correctamente!';
        } else {
            Grupo::create($data);
            $message = 'Grupo creado exitosamente!';
        }

        $this->loadAlumnosDisponibles();

        $this->cerrarModal();
        session()->flash('success', $message);
    }

    public function loadAlumnosDisponibles()
    {
        $this->alumnos = User::where('role', 'alumno')
            ->where(function ($query) {
                $query->whereDoesntHave('grupoComoAlumno')
                    ->orWhereHas('grupoComoAlumno', function ($q) {
                        $q->where('id', $this->grupoEditId);
                    });
            })
            ->orderBy('name')
            ->get();
    }

    public function editarGrupo($grupoId)
    {
        $grupo = Grupo::findOrFail($grupoId);

        $this->nuevoGrupo = [
            'empresa_id' => $grupo->empresa_id,
            'profesor_id' => $grupo->profesor_id,
            'alumno_id' => $grupo->alumno_id,
            'centro_docente' => $grupo->centro_docente,
            'tutor_empresa' => $grupo->tutor_empresa,
            'periodo_realizacion' => $grupo->periodo_realizacion,
            'curso_academico' => $grupo->curso_academico,
            'familia_profesional' => $grupo->familia_profesional,
            'ciclo' => $grupo->ciclo,
            'grado' => $grupo->grado
        ];

        $this->grupoEditId = $grupoId;
        $this->isEditing = true;
        $this->showCreateModal = true;
        $this->loadAlumnosDisponibles();
        $this->updateCiclosOptions();
    }

    public function cerrarModal()
    {
        $this->reset([
            'nuevoGrupo',
            'showCreateModal',
            'showEmpresasModal',
            'showAlumnosModal',
            'isEditing',
            'grupoEditId'
        ]);
        $this->loadData();
        $this->loadAlumnosDisponibles();
    }

    public function updatedNuevoGrupoEmpresaId($value)
    {
        if ($value) {
            $empresa = Empresa::find($value);
            $this->nuevoGrupo['tutor_empresa'] = $empresa->tutor ?? '';
        } else {
            $this->nuevoGrupo['tutor_empresa'] = '';
        }
    }


    public function confirmarEliminar($grupoId)
    {
        $this->grupoToDelete = Grupo::find($grupoId);

        if ($this->grupoToDelete) {
            $this->showDeleteModal = true;
        } else {
            session()->flash('error', 'No se encontró el grupo para eliminar.');
        }
    }


    public function eliminarGrupo()
    {
        if ($this->grupoToDelete) {
            $this->grupoToDelete->delete();

            $this->grupos = $this->grupos->filter(fn($g) => $g->id != $this->grupoToDelete->id);
            $this->loadAlumnosDisponibles();
            $this->reset(['grupoToDelete', 'showDeleteModal']);
            $this->dispatch('refreshComponent');
        }

        session()->flash('success', 'Grupo eliminado exitosamente!');
    }


    public function render()
    {
        return view('livewire.profesor.asignar-empresa');
    }

    public function refreshComponent()
    {
        $this->loadData();
        $this->render();
    }
}
