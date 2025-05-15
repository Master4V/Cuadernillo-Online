<!-- No inicia bien=> Mira miau-->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Cuadernillo Online</title>
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
        <style>
            /* Animación de fondo */
            .bg-animation {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: -1;
                opacity: 0.1;
                background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
                background-size: 400% 400%;
                animation: gradient 15s ease infinite;
            }
            
            @keyframes gradient {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }
        </style>
    </head>
    <body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col relative">        
        <!--header class="w-full lg:max-w-4xl max-w-[335px] mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-yellow-600 dark:text-gray-300">Hola, {{ auth()->user()->name }}</span>
                            <a
                                href="{{ route(auth()->user()->role.'.dashboard') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700"
                            >
                                Panel Principal
                            </a>
                        </div>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-yellow-700 bg-yellow-100 hover:bg-yellow-200 dark:text-white dark:bg-gray-700 dark:hover:bg-gray-600"
                        >
                            Iniciar sesión
                        </a>
        
                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-500 hover:bg-yellow-600"
                            >
                                Registrarse
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header-->
        <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden">
                <!-- Div de animación de fondo ->
                <div class="bg-animation"></div-->
                
                <!-- Contenido izquierdo (texto) -->
                <div class="text-[13px] leading-[20px] flex-1 p-8 lg:p-12 bg-white dark:bg-gray-800 dark:text-gray-200">
                    @auth
                        <h1 class="text-2xl text-yellow-700 font-bold mb-4">¡Bienvenido de vuelta, {{ auth()->user()->name }}!</h1>
                        <p class="mb-6 text-yellow-600 dark:text-gray-300">Estamos contentos de verte de nuevo en Cuadernillo Online.</p>
                    @else
                        <h1 class="text-2xl text-yellow-700 font-bold mb-4">Bienvenido a Cuadernillo Online</h1>
                        <p class="mb-6 text-yellow-600 dark:text-gray-300">Tu solución digital para registrar y gestionar tu FCT de manera eficiente.</p>
                    @endauth
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="flex items-center justify-center h-6 w-6 rounded-full bg-yellow-100 dark:bg-yellow-900">
                                    <svg class="h-4 w-4 text-yellow-600 dark:text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </div>
                            <p class="ml-3 text-yellow-600 dark:text-gray-300">
                                Registra tu trabajo de manera eficiente
                            </p>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="flex items-center justify-center h-6 w-6 rounded-full bg-yellow-100 dark:bg-yellow-900">
                                    <svg class="h-4 w-4 text-yellow-600 dark:text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </div>
                            <p class="ml-3 text-yellow-600 dark:text-gray-300">
                                Accede desde cualquier dispositivo
                            </p>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="flex items-center justify-center h-6 w-6 rounded-full bg-yellow-100 dark:bg-yellow-900">
                                    <svg class="h-4 w-4 text-yellow-600 dark:text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </div>
                            <p class="ml-3 text-yellow-600 dark:text-gray-300">
                                Colabora con otros usuarios
                            </p>
                        </div>
                    </div>
                    
                    <div class="mt-8">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route(auth()->user()->role.'.dashboard') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700">
                                    Ir al Panel Principal
                                </a>
                            @else
                                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                                    <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-yellow-500 hover:bg-yellow-600">
                                        Iniciar Sesión
                                    </a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-yellow-700 bg-yellow-100 hover:bg-yellow-200 dark:text-white dark:bg-gray-700 dark:hover:bg-gray-600">
                                            Registrarse
                                        </a>
                                    @endif
                                </div>
                            @endauth
                        @endif
                    </div>
                </div>
                
                <!-- Contenido derecho (imagen/ilustración) -->
<div class="bg-yellow-50 dark:bg-yellow-700 relative lg:-ml-px -mb-px lg:mb-0 rounded-t-lg lg:rounded-t-none lg:rounded-r-lg aspect-[335/376] lg:aspect-auto w-full lg:w-[438px] shrink-0 overflow-hidden flex items-center justify-center">
    <img src="{{ asset('images/Logo2.png') }}" alt="Cuadernillo Online Logo" class="w-64 h-auto object-contain">
</div>
  
            </main>
        </div>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>