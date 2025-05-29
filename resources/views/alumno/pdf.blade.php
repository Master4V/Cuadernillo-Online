<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Cuadernillo de Prácticas</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <style>
        /* Estilos generales */
        @page {
            size: A4;
            margin: 15mm;
        }

        body {
            font-family: "Arial", sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
            line-height: 1.4;
        }

        .page {
            width: 100%;
            height: 100%;
            page-break-after: always;
            position: relative;
        }

        .header-junta {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .title-junta {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
        }

        .subtitle-junta {
            font-size: 14px;
            font-weight: bold;
            margin: 5px 0 0 0;
        }

        .centro-docente {
            font-weight: bold;
            margin: 15px 0 5px 0;
        }

        .section-title {
            font-weight: bold;
            margin: 15px 0 5px 0;
            text-decoration: underline;
        }

        .firma-section {
            margin-top: 30px;
        }

        .firma-line {
            width: 60%;
            border-top: 1px solid #000;
            margin: 40px auto 5px auto;
            text-align: center;
            padding-top: 5px;
        }

        .footer-page {
            position: absolute;
            bottom: 10mm;
            width: 100%;
            text-align: center;
            font-size: 10px;
            border-top: 1px solid #000;
            padding-top: 3px;
        }

        /* Tablas */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 11px;
            page-break-inside: avoid;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        /* Portada */
        .portada {
            height: 100%;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo-colegio {
            width: 100px;
            height: 100px;
            margin: 0 auto 20px;
        }

        .titulo-portada {
            font-size: 20px;
            font-weight: bold;
            margin: 20px 0;
        }

        .ciclo-formativo {
            font-size: 16px;
            font-weight: bold;
            margin-top: 30px;
        }

        /* Estilos específicos para el documento */
        .info-field {
            margin: 5px 0;
        }

        .ra-item {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        .ra-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .evaluation-criteria {
            margin-left: 20px;
        }

        .evaluation-criteria li {
            margin-bottom: 5px;
        }

        .valoracion-table {
            margin-top: 15px;
        }

        .valoracion-table th,
        .valoracion-table td {
            text-align: center;
        }

        .questionnaire-table {
            margin-top: 10px;
            width: 100%;
        }

        .questionnaire-table th {
            text-align: center;
        }

        .questionnaire-table td:first-child {
            width: 70%;
            text-align: left;
        }

        .questionnaire-table td {
            width: 6%;
            text-align: center;
        }

        /* Estilos para los RA */
        .ra-container {
            margin-bottom: 20px;
        }

        .ra-header {
            font-weight: bold;

            margin-bottom: 5px;
        }

        .ra-description {
            font-size: 12px;
            margin-bottom: 10px;
        }

        .activities-list {
            list-style-type: disc;
            margin-left: 20px;
        }

        .criteria-list {
            list-style-type: decimal;
            margin-left: 20px;
        }

        .criteria-item {
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <!-- Variables para el contador de páginas -->
    @php
        // Calculamos el número total de páginas
        $totalPages = 5; // Portada + Programa formativo + Informe tutor + Cuestionario
        $totalPages += $practicas
            ->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->fecha)->startOfWeek()->format('Y-m-d');
            })
            ->count();

        // Inicializamos el contador de página actual
        $currentPage = 1;
    @endphp
    <!-- Portada -->
    <div class="page portada">
        <div>
            <div class="header-junta">
                <p class="title-junta">JUNTA DE ANDALUCÍA</p>
                <p class="subtitle-junta">FORMACIÓN EN CENTROS DE TRABAJO</p>
            </div>

            <img src="./images/logo-colegio.png" alt="Logo del colegio" class="logo-colegio">

            <div class="titulo-portada">LIBRO DE PRÁCTICAS</div>
            <div class="ciclo-formativo">C.F. Grado {{ $grupo->grado ?? 'No chabe' }} {{ $grupo->ciclo ?? 'No chabe' }}
            </div>

            <div style="margin-top: 500px;">
                <p>{{ $grupo->centro_docente ?? 'IES La Marisma' }}</p>
                <p>Huelva</p>
            </div>
        </div>

        <div class="footer-page">
            Consejería de Educación <span class="page-counter">(Hoja {{ $currentPage++ }} de {{ $totalPages }})</span>
        </div>
    </div>

    <!-- Página 2 - Programa formativo -->
    <div class="page">
        <div class="header-junta">
            <p class="title-junta">JUNTA DE ANDALUCÍA</p>
            <p class="subtitle-junta">FORMACIÓN EN CENTROS DE TRABAJO. PROGRAMA FORMATIVO</p>
        </div>

        <p class="centro-docente">CENTRO DOCENTE: {{ $grupo->centro_docente ?? 'IES La Marisma' }} </p>
        <p class="info-field">PROFESOR/PROFESORA RESPONSABLE DEL SEGUIMIENTO:
            {{ $grupo->profesor->name ?? 'Tutor académico no asignado' }}</p>
        <p class="info-field">ALUMNO/ALUMNA: {{ $alumno->name }}</p><br>

        <p class="info-field"><strong>CENTRO DE TRABAJO COLABORADOR:</strong>
            {{ $grupo->empresa->nombre ?? 'Empresa no asignada' }}</p>
        <p class="info-field">TUTOR/TUTORA DEL CENTRO DE TRABAJO:
            {{ $grupo->tutor_empresa ?? 'Tutor de empresa no asignado' }}</p>
        <p class="info-field">PERÍODO DE REALIZACIÓN DE LA FCT: {{ $grupo->periodo_realizacion ?? 'No especificado' }}
        </p><br>

        <p class="info-field"><strong>CURSO ESCOLAR:</strong> {{ $grupo->curso_academico ?? now()->format('Y') - 1 }}</p>
        <p class="info-field">FAMILIA PROFESIONAL: {{ $grupo->familia_profesional ?? 'No seleccionada' }} </p>
        <p class="info-field">CICLO FORMATIVO: {{ $grupo->ciclo ?? 'No seleccionado' }} </p>
        <p class="info-field">GRADO: {{ $grupo->grado ?? 'No seleccionado' }} </p>

        <div class="firma-section">
            <div class="firma-line">EL/LA PROFESOR/A RESPONSABLE DEL SEGUIMIENTO</div>
            <div class="firma-line">Fdo: _________________________</div>
            <div style="margin-top: 20px;" class="firma-line">EL/LA JEFE/A DEL DEPARTAMENTO DE FAMILIA PROFESIONAL</div>
            <div class="firma-line">Fdo: _________________________</div>
        </div>

        <div class="footer-page">
            Consejería de Educación <span class="page-counter">(Hoja {{ $currentPage++ }} de
                {{ $totalPages }})</span>
        </div>
    </div>
    <div class="page">
        <p class="section-title">RESULTADOS DE APRENDIZAJE</p>

        <!-- RA 1 -->
        <div class="ra-container">
            <div class="ra-header">RA1. Identifica la estructura y organización de la empresa, relacionándola con la
                producción y comercialización de los productos que obtiene.</div>
            <div class="ra-description">Identifica la estructura y organizacion de la empresa, relacionandola con la
                produccion y comercializacion de los productos que obtiene.</div>

            <p><strong>ACTIVIDADES FORMATIVO-PRODUCTIVAS:</strong></p>
            <ul class="activities-list">
                <li>Curso/charla iniciacion/presentacion sobre la estructura de la empresa y manuales de trabajo de las
                    distintas tareas que debera realizar el alumno.</li>
            </ul>

            <p><strong>CRITERIOS DE EVALUACIÓN:</strong></p>
            <ol class="criteria-list">
                <li class="criteria-item">Se han identificado la estructura organizativa de la empresa y las funciones
                    de cada area de la misma.</li>
                <li class="criteria-item">Se ha comparado la estructura de la empresa con las organzaciones
                    empresariales tipo existentes en el sector.</li>
                <li class="criteria-item">Se han identificado los elementos que constituyen la red logistica de la
                    empresa, proveedores, clientes, sistemas de produccion y almacenaje, entre otros.</li>
                <li class="criteria-item">Se han identificado los procedimientos de trabajo en el desarrollo de la
                    prestacion del servicio.</li>
                <li class="criteria-item">Se han valorado las competencias necesarias de los recursos humanos para el
                    desarrollo optimo de la actividad.</li>
                <li class="criteria-item">Se ha valorado la idoneidad de los canales de difusion mas frecuentes en esta
                    actividad.</li>
            </ol>
        </div>

        <!-- RA 2 -->
        <div class="ra-container">
            <div class="ra-header">RA2. Aplica hábitos éticos y laborales en el desarrollo de su actividad profesional,
                de acuerdo con las características del puesto de trabajo y con los procedimientos establecidos en la
                empresa.</div>
            <div class="ra-description">Aplica habitos eticos y laborales en el desarrollo de su actividad profesional,
                de acuerdo con las caracteristicas del puesto de trabajo y con los procedimientos establecidos en la
                empresa.</div>

            <p><strong>ACTIVIDADES FORMATIVO-PRODUCTIVAS:</strong></p>
            <ul class="activities-list">
                <li>Curso/charla de prevencion de riesgos laborales especificos del entorno de trabajo en el que
                    desempeñara sus funciones.</li>
                <li>Curso/charla de normas de funcionamiento, comportamiento, decoro que debera seguir el alumno</li>
                <li>Coordinara su trabajo con el resto de miembros del equipo siguiendo las indicaciones de su tutor o
                    persona encargada de su seguimiento a traves de reuniones periodicas siguiendo las directrices de la
                    metodologia de desarrollo utilizada en la empresa.</li>
            </ul>

            <p><strong>CRITERIOS DE EVALUACIÓN:</strong></p>
            <ol class="criteria-list">
                <li class="criteria-item">Se han reconocido y justificado:
                    <br>a. La disponibilidad personal y temporal necesaria en el puesto de trabajo.
                    <br>b. Las actitudes personales (puntualidad y empatia, entre otras) y profesionales (orden,
                    limpieza, responsabilidad, entre otras) necesarias para el puesto de trabajo.
                    <br>c. Los requerimientos actitudinales ante la prevencion de riesgos en la actividad profesional.
                    <br>d. Los requerimientos actudinales referidos a la calidad en la actividad laboral.
                    <br>e. Las actitudes relacionales con el propio equipo de trabajo y con las jerarquias establecidas
                    en la empresa.
                    <br>f. Las actitudes relacionadas con la documentacion de las actividades realizadas en el ambito
                    laboral.
                    <br>g. Las necesidades formativas para la insercion y reinsersion laboral en el ambito cientifico y
                    tecnico del buen hacer del profesional.
                </li>
                <li class="criteria-item">Se han identificado las normas de prevencion de riesgos laborales y los
                    aspectos fundamentales de la Ley de Prevencion de Riesgos Laborales de aplicacion en la actividad
                    profesional.</li>
                <li class="criteria-item">Se han aplicado los equipos de proteccion individual segun los riesgos de la
                    actividad profesional y las normas de la empresa.</li>
                <li class="criteria-item">Se ha mantenido una actitud de respeto al medio ambiente en las actividades
                    desarrolladas.</li>
                <li class="criteria-item">Se ha mantenido organizado, limpio y libre de obstaculos el puesto de trabajo
                    o area correspondiente al desarrollo de la actividad.</li>
                <li class="criteria-item">Se ha responsabilizado del trabajo asignado interpretando y cumpliendo las
                    instrucciones recibidas.</li>
                <li class="criteria-item">Se ha establecido una comunicacion eficaz con la persona responsable en cada
                    situacion y con los miembros del equipo.</li>
                <li class="criteria-item">Se ha coordinado con el resto del equipo comunicando las incidencias
                    relevantes que se presenten.</li>
                <li class="criteria-item">Se ha valorado la importancia de su actividad y la necesidad de adaptacion a
                    los cambios de tareas.</li>
                <li class="criteria-item">Se ha responsabilizado de la aplicacion de las normas y procedimientos en el
                    desarrollo de su trabajo.</li>
            </ol>
        </div>

        <!-- RA 3 -->
        <div class="ra-container">
            <div class="ra-header">RA3. Organiza los trabajos que se han de desarrollar, identificando las tareas
                asignadas a partir de la planificación de proyectos e interpretando documentación específica.</div>
            <div class="ra-description">Organiza los trabajos que se han de desarrollar, identificando las tareas
                asignadas a partir de la planificacion de proyectos e interpretando documentacion especifica.</div>

            <p><strong>ACTIVIDADES FORMATIVO-PRODUCTIVAS:</strong></p>
            <ul class="activities-list">
                <li>Participar en el desarrollo de proyectos de la empresa creando software para responder a un analisis
                    de requisitos previo y diseño proporcionado por su tutor o supervisores cumpliendo las restrucciones
                    temporales que se indiquen.</li>
                <li>Planificara y distribuira temporalmente las tareas de desarrollo encargadas por sus responsables.
                </li>
            </ul>

            <p><strong>CRITERIOS DE EVALUACIÓN:</strong></p>
            <ol class="criteria-list">
                <li class="criteria-item">Se ha interpretado la normativa o bibliografia adecuada al tipo de tarea a
                    desarrollar.</li>
                <li class="criteria-item">Se ha reconocido en que fases del proceso o proyecto se encuadran las tareas
                    que se van a realizar.</li>
                <li class="criteria-item">Se ha planificado el trabajo para cada tarea, secuenciando y priorizando sus
                    fases.</li>
                <li class="criteria-item">Se han identificado los equipos y servicios auxiliares necesarios para el
                    desarrollo de la tarea encomendada.</li>
                <li class="criteria-item">Se ha organizado el aprovisionamiento y almacenaje de los recursos materiales.
                </li>
                <li class="criteria-item">Se ha valorado el orden y el metodo en la realizacion de las tareas.</li>
                <li class="criteria-item">Se han identificado las normativas que sea preciso observar segun cada tarea.
                </li>
            </ol>
        </div>

        <!-- RA 4 -->
        <div class="ra-container">
            <div class="ra-header">RA4. Gestiona y utiliza sistemas informáticos y entornos de desarrollo, evaluando sus
                requerimientos y características en función del propósito de uso.</div>
            <div class="ra-description">Gestiona y utiliza sistemas informaticos y entornos de desarrollo, evaluando sus
                requerimientos y caracteristicas en funcion del proposito de uso.</div>

            <p><strong>ACTIVIDADES FORMATIVO-PRODUCTIVAS:</strong></p>
            <ul class="activities-list">
                <li>Utilizara entornos de desarrollo y sistemas informaticos proporcionados por la empresa para
                    desarrollar proyectos software.</li>
                <li>Participara o tendra conocimiento de todas las fases de desarrollo que existen en el proyecto del
                    que es participe.</li>
                <li>Elaborara la documentacion tecnica pertinente acorde a los procedimiento de la empresa para el
                    subsistema del que sea participe.</li>
                <li>Trabajara con los sistemas HW de desarrollo utilizados en la empresa para la creacion de la
                    aplicacion. Tendra conocimiento de los procedimientos de despliegue de la aplicacion en sistemas de
                    produccion.</li>
            </ul>

            <p><strong>CRITERIOS DE EVALUACIÓN:</strong></p>
            <ol class="criteria-list">
                <li class="criteria-item">Se ha trabajado sobre diferentes sistemas informaticos, identificando en cada
                    caso su hardware, sistemas operativos y aplicaciones instaladas y las restricciones o condiciones
                    especificas de uso.</li>
                <li class="criteria-item">Se ha gestionado la informacion en diferentes sistemas, aplicando medidas que
                    aseguren la integridad y disponibilidad de los datos.</li>
                <li class="criteria-item">Se ha participado en la gestion de recursos en red identificando las
                    restriccionesde seguridad existentes.</li>
                <li class="criteria-item">Se han utilizado aplicaciones informaticas para elaborar, distribuir y
                    mantener documentacion tecnica y de asistencia a usuarios.</li>
                <li class="criteria-item">Se han utilizado entornos de desarrollo para editar, depurar, probar y
                    documentar codigo, ademas de generar ejecutables.</li>
                <li class="criteria-item">Se han gestionado entornos de desarrollo añadiendo y empleando complementos
                    especificos en las distintas fases de proyectos de desarrollo.</li>
            </ol>
        </div>

        <!-- RA 5 -->
        <div class="ra-container">
            <div class="ra-header">RA5. Participa en el desarrollo de aplicaciones con acceso a datos planificando la
                estructura de la base de datos y evaluando el alcance y la repercusion de las transacciones.</div>
            <div class="ra-description">Participa en el desarrollo de aplicaciones con acceso a datos planificando la
                estructura de la base de datos y evaluando el alcance y la repercusion de las transacciones.</div>

            <p><strong>ACTIVIDADES FORMATIVO-PRODUCTIVAS:</strong></p>
            <ul class="activities-list">
                <li>Estudiara y tendra conocimiento del modelo de datos del subsistema en el que este trabajando,
                    desarrollando operaciones de consulta o actualizacion, si procede, sobre las mismas en el desarrollo
                    de la aplicacion sobre la que trabaje.</li>
            </ul>

            <p><strong>CRITERIOS DE EVALUACIÓN:</strong></p>
            <ol class="criteria-list">
                <li class="criteria-item">Se ha interpretado el diseño logico de bases de datos que aseguran la
                    accesibilidad a los datos.</li>
                <li class="criteria-item">Se ha participado en la materializacion del diseño logico sobre algun sistema
                    gestor de bases de datos.</li>
                <li class="criteria-item">Se han utilizado bases de datos aplicando tecnicas para mantener la
                    persistencia de la informacion.</li>
                <li class="criteria-item">Se han ejecutado consultas directas y procedimientos capaces de gestionar y
                    almacenar objetos y datos de la base de datos.</li>
                <li class="criteria-item">Se han establecido conexiones con bases de datos para ejecutar consultas y
                    recuperar los resultados en objetos de acceso a datos.</li>
                <li class="criteria-item">Se han desarrollado formularios e informes como parte de aplicaciones que
                    gestionan de forma integral la informacion almacenada en una base de datos.</li>
                <li class="criteria-item">Se ha comprobado la configuracion de los servicios de red para garantizar la
                    ejecucion segura de las aplicaciones Cliente-Servidor.</li>
                <li class="criteria-item">Se ha elaborado la documentacion asociada a la gestion de las bases de datos
                    empleadas y las aplicaciones desarrolladas.</li>
            </ol>
        </div>

        <!--div class="firma-section">
            <div class="firma-line">EL/LA PROFESOR/A RESPONSABLE DEL SEGUIMIENTO</div>
            <div class="firma-line">Fdo: _________________________</div>
            <div style="margin-top: 20px;" class="firma-line">EL/LA JEFE/A DEL DEPARTAMENTO DE FAMILIA PROFESIONAL</div>
            <div class="firma-line">Fdo: _________________________</div>
        </div-->

        <div class="footer-page">
            Consejería de Educación <span class="page-counter">(Hoja {{ $currentPage++ }} de
                {{ $totalPages }})</span>
        </div>
    </div>

    <!-- Páginas de registro semanal -->
    @foreach ($practicas->groupBy(function ($item) {
        return \Carbon\Carbon::parse($item->fecha)->startOfWeek()->format('Y-m-d');
    }) as $week => $weeklyPractices)
        @if ($weeklyPractices->count() > 0)
            <div class="page">
                <div class="header-junta">
                    <p class="title-junta">JUNTA DE ANDALUCÍA</p>
                    <p class="subtitle-junta">FORMACIÓN EN CENTROS DE TRABAJO. FICHA SEMANAL DEL ALUMNO/ALUMNA</p>
                </div>

                @php
                    $startOfWeek = \Carbon\Carbon::parse($week);
                    $endOfWeek = $startOfWeek->copy()->endOfWeek();
                @endphp

                <p>Semana del {{ $startOfWeek->format('d/m') }} al {{ $endOfWeek->format('d/m') }} de
                    {{ $startOfWeek->isoFormat('MMMM') }} de {{ $startOfWeek->format('Y') }}.</p>

                <p><strong>CENTRO DOCENTE:</strong> {{ $grupo->centro_docente ?? 'IES La Marisma' }} </p>
                <p><strong>PROFESOR/PROFESORA RESPONSABLE SEGUIMIENTO:</strong>
                    {{ $grupo->profesor->name ?? 'Tutor académico no asignado' }}</p>
                <p><strong>CENTRO DE TRABAJO COLABORADOR:</strong>
                    {{ $grupo->empresa->nombre ?? 'Empresa no asignada' }}
                </p>
                <p><strong>TUTOR/TUTORA DEL CENTRO DE TRABAJO:</strong>
                    {{ $grupo->tutor_empresa ?? 'Tutor de empresa no asignado' }}</p>
                <p><strong>CICLO FORMATIVO:</strong> {{ $grupo->ciclo ?? 'No seleccionado' }}</p>

                <table>
                    <thead>
                        <tr>
                            <th style="width: 15%;">DÍA</th>
                            <th style="width: 50%;">ACTIVIDAD DESARROLLADA</th>
                            <th style="width: 15%;">TIEMPO EMPLEADO</th>
                            <th style="width: 20%;">OBSERVACIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($weeklyPractices as $practica)
                            <tr>
                                <td>{{ $practica->fecha->isoFormat('dddd') }}</td>
                                <td>{{ $practica->actividad }}</td>
                                <td>{{ $practica->horas }} horas</td>
                                <td>{{ $practica->observaciones ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="firma-section">
                    <div class="firma-line">EL/LA ALUMNO/A</div>
                    <div class="firma-line">VºBº EL/LA PROFESOR/A RESPONSABLE DEL SEGUIMIENTO</div>
                    <div class="firma-line">VºBº EL/LA TUTOR/A DEL CENTRO DE TRABAJO</div>
                </div>

                <div class="footer-page">
                    Consejería de Educación <span class="page-counter">(Hoja {{ $currentPage++ }} de
                        {{ $totalPages }})</span>
                </div>
            </div>
        @endif
    @endforeach

    <!-- Página de informe del tutor -->
    <div class="page">
        <div class="header-junta">
            <p class="title-junta">JUNTA DE ANDALUCÍA</p>
            <p class="subtitle-junta">FORMACIÓN EN CENTROS DE TRABAJO. INFORME DEL TUTOR O TUTORA DEL CENTRO DE TRABAJO
            </p>
        </div>

        <p><strong>ALUMNO/ALUMNA:</strong> {{ $alumno->name }}</p>
        <p><strong>CENTRO DOCENTE:</strong> {{ $grupo->centro_docente ?? 'IES La Marisma' }} </p>
        <p><strong>CICLO FORMATIVO:</strong> {{ $grupo->ciclo ?? 'No seleccionado' }} </p>
        <p><strong>GRADO:</strong> {{ $grupo->grado ?? 'No seleccionado' }} </p>
        <p><strong>CENTRO DE TRABAJO:</strong> {{ $grupo->empresa->nombre ?? 'Empresa no asignada' }}</p>
        <p><strong>HORAS REALIZADAS:</strong> {{ $totalHoras }}</p>
        <p><strong>TUTOR/A DEL ALUMNO O ALUMNA EN EL CENTRO DE TRABAJO:</strong>
            {{ $grupo->tutor_empresa ?? 'Tutor de empresa no asignado' }}</p>
        <p><strong>PROFESORADO RESPONSABLE DEL SEGUIMIENTO:</strong>
            {{ $grupo->profesor->name ?? 'Tutor académico no asignado' }}</p>

        <p class="section-title">1.- ÁREAS Y PUESTOS DE TRABAJO DONDE HA DESARROLLADO LAS ACTIVIDADES FORMATIVAS:</p>
        <p>__________________________________________________________________</p>
        <p>__________________________________________________________________</p>

        <p class="section-title">2.- VALORACIÓN DE LA ESTANCIA DEL ALUMNO/ALUMNA EN EL CENTRO DE TRABAJO:</p>
        <table class="valoracion-table">
            <thead>
                <tr>
                    <th>ASPECTOS A CONSIDERAR</th>
                    <th>NEGATIVA</th>
                    <th>POSITIVA</th>
                    <th>EXCELENTE</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Competencias profesionales</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Competencias organizativas</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Competencias relacionales</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Capacidad de respuesta a las contingencias</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Otros aspectos</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <p class="section-title">3.- MODIFICACIONES A INTRODUCIR EN EL PROGRAMA FORMATIVO:</p>
        <p>__________________________________________________________________</p>
        <p>__________________________________________________________________</p>

        <div class="firma-section">
            <div class="firma-line">EL/LA TUTOR/A DEL CENTRO DE TRABAJO</div>
            <div class="firma-line">Fdo: _________________________</div>
            <div style="margin-top: 20px;">
                <p>En Huelva, a ___ de __________ de {{ now()->format('Y') }}</p>
            </div>
        </div>

        <div class="footer-page">
            Consejería de Educación <span class="page-counter">(Hoja {{ $currentPage++ }} de
                {{ $totalPages }})</span>
        </div>
    </div>

    <!-- Página de cuestionario del alumno -->
    <div class="page" style="page-break-after: auto;">
        <div class="header-junta">
            <p class="title-junta">JUNTA DE ANDALUCÍA</p>
            <p class="subtitle-junta">FORMACIÓN EN CENTROS DE TRABAJO. CUESTIONARIO DEL ALUMNO</p>
        </div>

        <p class="section-title">Datos del Ciclo Formativo</p>
        <p><strong>Nombre del ciclo Formativo:</strong> {{ $grupo->ciclo ?? 'No seleccionado' }} </p>
        <p><strong>Curso Académico:</strong> {{ $grupo->curso_academico ?? now()->format('Y') - 1 }}</p>
        <p><strong>Período Realización FCT:</strong> {{ $grupo->periodo_realizacion ?? 'No especificado' }}</p>

        <p class="section-title">Valoración de los Centros de Trabajo</p>
        <p><strong>Nombre empresa:</strong> {{ $grupo->empresa->nombre ?? 'Empresa no asignada' }}</p>

        <table class="questionnaire-table">
            <thead>
                <tr>
                    <th>Indicadores (1= Poco, 5 = mucho)</th>
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                    <th>4</th>
                    <th>5</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Posibilidades formativas que ofrece la empresa</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Cumplimiento del programa formativo por parte de la empresa</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Seguimiento del alumno realizado por el tutor/a del centro de trabajo</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Seguimiento hecho por su profesor/a</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Posibilidades laborales que ofrece la empresa al alumnado que finaliza la fase de formación en
                        centros de trabajo</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Adecuación de la formación recibida en el centro docente con las prácticas realizadas</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Nivel de satisfacción mostrado con la empresa por el alumnado que ha realizado la fase de
                        formación en centros de trabajo en ella</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Valoracion general de las practicas por el profesor/a responsable del seguimiento</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <p class="section-title">Aspectos a mejorar de la fase de formación en centros de trabajo:</p>
        <p>__________________________________________________________________</p>
        <p>__________________________________________________________________</p>

        <p class="section-title">Aspectos a destacar de la fase de formación en centros de trabajo:</p>
        <p>__________________________________________________________________</p>
        <p>__________________________________________________________________</p>

        <div class="footer-page">
            Consejería de Educación <span class="page-counter">(Hoja {{ $currentPage++ }} de
                {{ $totalPages }})</span>
        </div>
    </div>
</body>

</html>
