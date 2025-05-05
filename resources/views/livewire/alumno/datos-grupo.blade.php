<div>
    <!-- Acordeón -->
    <div class="bg-white shadow-sm rounded-lg overflow-hidden mb-6">
        <button wire:click="toggleAccordion"
            class="w-full px-6 py-4 text-left font-medium text-gray-900 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <div class="flex justify-between items-center">
                <span>Datos Académicos y de Prácticas</span>
                <svg class="w-5 h-5 transform transition-transform duration-200 {{ $expanded ? 'rotate-180' : '' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </button>

        <div class="px-6 py-4 transition-all duration-200 {{ $expanded ? 'block' : 'hidden' }}">
            @if ($grupo)
                <!-- Bloques de información -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Bloque Centro Educativo -->
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="font-medium text-blue-800 mb-4">Centro Educativo</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Centro docente:</p>
                                <p class="text-sm text-gray-900">{{ $centro_docente ?: 'Pendiente de completar' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Profesor responsable:</p>
                                <p class="text-sm text-gray-900">
                                    {{ $nombre_profesor_practicas ?: 'Pendiente de completar' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Alumno:</p>
                                <p class="text-sm text-gray-900">{{ $alumno->name }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Bloque Empresa -->
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h3 class="font-medium text-green-800 mb-4">Empresa</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Centro de trabajo:</p>
                                <p class="text-sm text-gray-900">{{ $empresa_practicas ?: 'Pendiente de completar' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Tutor empresa:</p>
                                <p class="text-sm text-gray-900">{{ $tutor_empresa ?: 'Pendiente de completar' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Periodo FCT:</p>
                                <p class="text-sm text-gray-900">{{ $periodo_realizacion ?: 'Pendiente de completar' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bloque Datos Académicos -->
                <div class="bg-purple-50 p-4 rounded-lg mb-6">
                    <h3 class="font-medium text-purple-800 mb-4">Datos Académicos</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Curso escolar:</p>
                            <p class="text-sm text-gray-900">{{ $curso_academico ?: 'Pendiente de completar' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Familia profesional:</p>
                            <p class="text-sm text-gray-900">{{ $familia_profesional ?: 'Pendiente de completar' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Ciclo:</p>
                            <p class="text-sm text-gray-900">{{ $ciclo ?: 'Pendiente de completar' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Grado:</p>
                            <p class="text-sm text-gray-900">{{ $grado ?: 'Pendiente de completar' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex gap-4 mt-6">
                    <button wire:click="openModal"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        ✏️ Editar Datos
                    </button>
                    <button wire:click="openRAModal"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                        📚 R.A. (Resultados de Aprendizaje)
                    </button>
                </div>
            @else
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <p class="text-yellow-700">No estás asignado a ningún grupo.</p>
                </div>
            @endif
        </div>
    </div>

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
                    <!-- Sección Centro Educativo -->
                    <div class="bg-blue-50 p-4 rounded-lg mb-6">
                        <h4 class="font-medium text-blue-800 mb-4">Centro Educativo</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Centro docente</label>
                                <input wire:model="centro_docente" type="text"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Profesor responsable</label>
                                <input wire:model="nombre_profesor_practicas" type="text"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Sección Empresa -->
                    <div class="bg-green-50 p-4 rounded-lg mb-6">
                        <h4 class="font-medium text-green-800 mb-4">Empresa</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Empresa</label>
                                <input wire:model="empresa_practicas" type="text"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Tutor empresa</label>
                                <input wire:model="tutor_empresa" type="text"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
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

    <!-- Modal Resultados de Aprendizaje Mejorado -->
    @if ($showRAModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 overflow-hidden">
        <div class="bg-white rounded-lg w-full max-w-7xl mx-4 my-8 flex flex-col" style="max-height: 90vh;">
                <!-- Cabecera -->
                <div class="flex justify-between items-center p-6 border-b sticky top-0 bg-white z-10">
                    <h3 class="text-xl font-semibold">Resultados de Aprendizaje</h3>
                    <button wire:click="closeRAModal" class="text-gray-500 hover:text-gray-700 text-2xl">
                        &times;
                    </button>
                </div>

                <!-- Contenido -->
                <div class="p-6 overflow-y-auto flex-grow">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase w-1/4">
                                        Resultados de Aprendizaje</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase w-1/3">
                                        Actividades Formativo-Productivas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase w-1/3">
                                        Criterios de Evaluación</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <!-- Columna R.A. -->
                                    <td class="px-6 py-4 whitespace-normal align-top">
                                        <p class="font-semibold text-blue-600">RA1.</p>
                                        <p class="text-sm text-gray-600 mt-2">Identifica la estructura y organizacion de la empresa, relacionandola con la produccion y comercializacion de los productos que obtiene.</p>
                                    </td>   
                                    <!-- Columna Actividades -->
                                    <td class="px-6 py-4 align-top">
                                        <div class="max-h-40 overflow-y-auto">
                                            <ul class="list-disc pl-5 space-y-2 text-sm">
                                                <li>Curso/charla iniciacion/presentacion sobre la estructura de la empresa y manuales de trabajo de las distintas tareas que debera realizar el alumno.</li>
                                            </ul>
                                        </div>
                                    </td>

                                    <!-- Columna Criterios -->
                                    <td class="px-6 py-4 align-top">
                                        <div class="max-h-40 overflow-y-auto">
                                            <ul class="list-decimal pl-5 space-y-2 text-sm">
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se han identificado la estructura organizativa de la empresa y las funciones de cada area de la misma.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se ha comparado la estructura de la empresa con las organzaciones empresariales tipo existentes en el sector.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se han identificado los elementos que constituyen la red logistica de la empresa, proveedores, clientes, sistemas de produccion y almacenaje, entre otros.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se han identificado los procedimientos de trabajo en el desarrollo de la prestacion del servicio.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se han valorado las competencias necesarias de los recursos humanos para el desarrollo optimo de la actividad.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se ha valorado la idoneidad de los canales de difusion mas frecuentes en esta actividad.</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="px-6 py-4 whitespace-normal align-top">
                                        <p class="font-semibold text-blue-600">RA2.</p>
                                        <p class="text-sm text-gray-600 mt-2">Aplica habitos eticos y laborales en el desarrollo de su actividad profesional, de acuerdo con las caracteristicas del puesto de trabajo y con los procedimientos establecidos en la empresa.</p>
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        <div class="max-h-40 overflow-y-auto">
                                            <ul class="list-disc pl-5 space-y-2 text-sm">
                                                <li>Curso/charla de prevencion de riesgos laborales especificos del entorno de trabajo en el que desempeñara sus funciones.</li>
                                                <li>Curso/charla de normas de funcionamiento, comportamiento, decoro que debera seguir el alumno</li>
                                                <li>Coordinara su trabajo con el resto de miembros del equipo siguiendo las indicaciones de su tutor o persona encargada de su seguimiento a traves de reuniones periodicas siguiendo las directrices de la metodologia de desarrollo utilizada en la empresa.</li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        <div class="max-h-40 overflow-y-auto">
                                            <ul class="list-decimal pl-5 space-y-2 text-sm">
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se han reconocido y justificado: </br> a.La disponibilidad personal y temporal necesaria en el puesto de trabajo.
                                                    <br>b.Las actitudes personales (puntualidad y empatia, entre otras) y profesionales (orden, limpieza, responsabilidad, entre otras) necesarias para el puesto de trabajo.
                                                    <br>c.Los requerimientos actitudinales ante la prevencion de riesgos en la actividad profesional.
                                                    <br>d.Los requerimientos actudinales referidos a la calidad en la actividad laboral.
                                                    <br>e.Las actitudes relacionales con el propio equipo de trabajo y con las jerarquias establecidas en la empresa.
                                                    <br>f.Las actitudes relacionadas con la documentacion de las actividades realizadas en el ambito laboral.
                                                    <br>g.Las necesidades formativas para la insercion y reinsersion laboral en el ambito cientifico y tecnico del buen hacer del profesional. </span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se han identificado las normas de prevencion de riesgos laborales y los aspectos fundamentales de la Ley de Prevencion de Riesgos Laborales de aplicacion en la actividad profesional.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se han aplicado los equipos de proteccion individual segun los riesgos de la actividad profesional y las normas de la empresa.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se ha mantenido una actitud de respeto al medio ambiente en las actividades desarrolladas.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se ha mantenido organizado, limpio y libre de obstaculos el puesto de trabajo o area correspondiente al desarrollo de la actividad.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se ha responsabilizado del trabajo asignado interpretando y cumpliendo las instrucciones recibidas.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se ha establecido una comunicacion eficaz con la persona responsable en cada situacion y con los miembros del equipo.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se ha coordinado con el resto del equipo comunicando las incidencias relevantes que se presenten.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se ha valorado la importancia de su actividad y la necesidad de adaptacion a los cambios de tareas.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se ha responsabilizado de la aplicacion de las normas y procedimientos en el desarrollo de su trabajo.</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="px-6 py-4 whitespace-normal align-top">
                                        <p class="font-semibold text-blue-600">RA3.</p>
                                        <p class="text-sm text-gray-600 mt-2">Organiza los trabajos que se han de desarrollar, identificando las tareas asignadas a partir de la planificacion de proyectos e interpretando documentacion especifica.</p>
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        <div class="max-h-40 overflow-y-auto">
                                            <ul class="list-disc pl-5 space-y-2 text-sm">
                                                <li>Participar en el desarrollo de proyectos de la empresa creando software para responder a un analisis de requisitos previo y diseño proporcionado por su tutor o supervisores cumpliendo las restrucciones temporales que se indiquen.</li>
                                                <li>Planificara y distribuira temporalmente las tareas de desarrollo encargadas por sus responsables.</li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        <div class="max-h-40 overflow-y-auto">
                                            <ul class="list-decimal pl-5 space-y-2 text-sm">
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se ha interpretado la normativa o bibliografia adecuada al tipo de tarea a desarrollar.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se ha reconocido en que fases del proceso o proyecto se encuadran las tareas que se van a realizar.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se ha planificado el trabajo para cada tarea, secuenciando y priorizando sus fases.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se han identificado los equipos y servicios auxiliares necesarios para el desarrollo de la tarea encomendada.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se ha organizado el aprovisionamiento y almacenaje de los recursos materiales.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se ha valorado el orden y el metodo en la realizacion de las tareas.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se han identificado las normativas que sea preciso observar segun cada tarea.</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="px-6 py-4 whitespace-normal align-top">
                                        <p class="font-semibold text-blue-600">RA4.</p>
                                        <p class="text-sm text-gray-600 mt-2">Gestiona y utiliza sistemas informaticos y entornos de desarrollo, evaluando sus requerimientos y caracteristicas en funcion del proposito de uso.</p>
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        <div class="max-h-40 overflow-y-auto">
                                            <ul class="list-disc pl-5 space-y-2 text-sm">
                                                <li>Utilizara entornos de desarrollo y sistemas informaticos proporcionados por la empresa para desarrollar proyectos software.</li>
                                                <li>Participara o tendra conocimiento de todas las fases de desarrollo que existen en el proyecto del que es participe.</li>
                                                <li>Elaborara la documentacion tecnica pertinente acorde a los procedimiento de la empresa para el subsistema del que sea participe.</li>
                                                <li>Trabajara con los sistemas HW de desarrollo utilizados en la empresa para la creacion de la aplicacion. Tendra conocimiento de los procedimientos de despliegue de la aplicacion en sistemas de produccion.</li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        <div class="max-h-40 overflow-y-auto">
                                            <ul class="list-decimal pl-5 space-y-2 text-sm">
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se ha trabajado sobre diferentes sistemas informaticos, identificando en cada caso su hardware, sistemas operativos y aplicaciones instaladas y las restricciones o condiciones especificas de uso.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se ha gestionado la informacion en diferentes sistemas, aplicando medidas que aseguren la integridad y disponibilidad de los datos.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se ha participado en la gestion de recursos en red identificando las restriccionesde seguridad existentes.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se han utilizado aplicaciones informaticas para elaborar, distribuir y mantener documentacion tecnica y de asistencia a usuarios.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se han utilizado entornos de desarrollo para editar, depurar, probar y documentar codigo, ademas de generar ejecutables.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se han gestionado entornos de desarrollo añadiendo y empleando complementos especificos en las distintas fases de proyectos de desarrollo.</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="px-6 py-4 whitespace-normal align-top">
                                        <p class="font-semibold text-blue-600">RA5.</p>
                                        <p class="text-sm text-gray-600 mt-2">Participa en el desarrollo de aplicaciones con acceso a datos planificando la estructura de la base de datos y evaluando el alcance y la repercusion de las transacciones.</p>
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        <div class="max-h-40 overflow-y-auto">
                                            <ul class="list-disc pl-5 space-y-2 text-sm">
                                                <li>Estudiara y tendra conocimiento del modelo de datos del subsistema en el que este trabajando, desarrollando operaciones de consulta o actualizacion, si procede, sobre las mismas en el desarrollo de la aplicacion sobre la que trabaje.</li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        <div class="max-h-40 overflow-y-auto">
                                            <ul class="list-decimal pl-5 space-y-2 text-sm">
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se ha interpretado el diseño logico de bases de datos que aseguran la accesibilidad a los datos.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se ha participado en la materializacion del diseño logico sobre algun sistema gestor de bases de datos.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se han utilizado bases de datos aplicando tecnicas para mantener la persistencia de la informacion.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se han ejecutado consultas directas y procedimientos capaces de gestionar y almacenar objetos y datos de la base de datos.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se han establecido conexiones con bases de datos para ejecutar consultas y recuperar los resultados en objetos de acceso a datos.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se han desarrollado formularios e informes como parte de aplicaciones que gestionan de forma integral la informacion almacenada en una base de datos.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se ha comprobado la configuracion de los servicios de red para garantizar la ejecucion segura de las aplicaciones Cliente-Servidor.</span>
                                                </li>
                                                <li class="text-green-600">
                                                    <span class="text-gray-700">Se ha elaborado la documentacion asociada a la gestion de las bases de datos empleadas y las aplicaciones desarrolladas.</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pie del modal -->
                <div class="p-4 border-t bg-gray-50">
                    <div class="flex justify-end">
                        <button wire:click="closeRAModal"
                            class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Mensaje flash -->
    @if (session('message'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg">
            {{ session('message') }}
        </div>
    @endif
</div>
