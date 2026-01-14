<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Login -->
        <div>
            <label for="login" class="block font-bold text-sm text-gray-400">Login</label>
            <input id="login" class="block mt-1 w-full bg-black border border-gray-800 focus:border-white focus:ring-0 text-white rounded-md shadow-sm placeholder-gray-600" type="text" name="login" :value="old('login')" required autofocus autocomplete="username" placeholder="Pseudo ou email" />
            <x-input-error :messages="$errors->get('login')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4" x-data="{ show: false }">
            <div class="flex justify-between items-center mb-1">
                <label for="password" class="block font-bold text-sm text-gray-400">Mot de passe</label>
                <button type="button" @click="show = !show" class="text-xs text-blue-400 hover:text-white transition">
                    <span x-show="!show">Afficher</span>
                    <span x-show="show" style="display: none;">Masquer</span>
                </button>
            </div>
            <input id="password" class="block mt-1 w-full bg-black border border-gray-800 focus:border-white focus:ring-0 text-white rounded-md shadow-sm placeholder-gray-600"
                            :type="show ? 'text' : 'password'"
                            name="password"
                            required autocomplete="current-password" 
                            placeholder="••••••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-8">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-500 hover:text-white rounded-md focus:outline-none" href="{{ route('password.request') }}">
                    Mot de passe oublié ?
                </a>
            @endif

            <button class="ms-3 bg-white hover:bg-gray-200 text-black font-bold py-2 px-6 rounded-full transition duration-200 ease-in-out">
                Connexion
            </button>
        </div>
        
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-500">
                Pas encore de compte ? 
                <a href="{{ route('register') }}" class="text-white font-bold hover:underline">S'inscrire</a>
            </p>
        </div>
    </form>
</x-guest-layout>
