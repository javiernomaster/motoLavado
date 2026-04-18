<x-guest-layout>

    <div class="text-center mb-6">
        <img src="{{ asset('images/logoM.png') }}">

        <h1 class="text-3xl font-bold text-indigo-600">MotoLavado</h1>
        <p class="text-sm text-gray-500">Sistema de gestión de lavado de motos</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="'Correo electrónico'" />
            <x-text-input id="email" class="block mt-1 w-full"
                type="email" name="email"
                :value="old('email')"
                required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="'Contraseña'" />
            <x-text-input id="password" class="block mt-1 w-full"
                type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember -->
        <div class="block mt-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="remember"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm">
                <span class="ms-2 text-sm text-gray-600">Recordarme</span>
            </label>
        </div>

        <!-- Botones -->
        <div class="flex items-center justify-between mt-4">
            <a href="{{ route('register') }}"
               class="text-sm text-indigo-600 hover:underline">
                Crear cuenta
            </a>
            <x-primary-button>
                Ingresar
            </x-primary-button>
        </div>

    </form>
</x-guest-layout>