<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block font-bold text-sm text-gray-400">Pseudo</label>
            <input id="name" class="block mt-1 w-full bg-black border border-gray-800 focus:border-white focus:ring-0 text-white rounded-md shadow-sm placeholder-gray-600" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="MonPseudo" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Adresse email -->
        <div class="mt-4">
            <label for="email" class="block font-bold text-sm text-gray-400">Courriel</label>
            <input id="email" class="block mt-1 w-full bg-black border border-gray-800 focus:border-white focus:ring-0 text-white rounded-md shadow-sm placeholder-gray-600" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="votre@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Mot de passe -->
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
                            required autocomplete="new-password" placeholder="12 carac. min, spécial & chiffres..." />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmation du mot de passe -->
        <div class="mt-4" x-data="{ show: false }">
            <div class="flex justify-between items-center mb-1">
                <label for="password_confirmation" class="block font-bold text-sm text-gray-400">Confirmation</label>
                <button type="button" @click="show = !show" class="text-xs text-blue-400 hover:text-white transition">
                    <span x-show="!show">Afficher</span>
                    <span x-show="show" style="display: none;">Masquer</span>
                </button>
            </div>
            <input id="password_confirmation" class="block mt-1 w-full bg-black border border-gray-800 focus:border-white focus:ring-0 text-white rounded-md shadow-sm placeholder-gray-600"
                            :type="show ? 'text' : 'password'"
                            name="password_confirmation" required autocomplete="new-password" placeholder="Répétez le mot de passe" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-8">
            <button class="w-full bg-white hover:bg-gray-200 text-black font-bold py-3 px-6 rounded-full transition duration-200 ease-in-out">
                S'inscrire
            </button>
        </div>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-500">
                Déjà inscrit ? 
                <a href="{{ route('login') }}" class="text-white font-bold hover:underline">Connexion</a>
            </p>
        </div>
    </form>
</x-guest-layout>
