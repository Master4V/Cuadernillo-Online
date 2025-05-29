<x-guest-layout>
    <div class="mb-4 text-sm text-yellow-600">
        {{ __('¿Olvidaste tu contraseña? No hay problema. Ponte en contacto con tu tutor de practicas para restablecer la contraseña.') }}
    </div>

    <!-- Session Status -- >
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <-- Email Address -- >
        <div>
            <x-input-label for="email" :value="__('Correo Electronico')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Enviar Enlace') }}
            </x-primary-button>
        </div>
    </form-->
    <div class="flex items-center justify-end mt-4">
        <a href="{{ route('welcome') }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:bg-yellow-600 active:bg-yellow-800 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
            {{ __('Volver') }}
        </a>
    </div>
</x-guest-layout>
