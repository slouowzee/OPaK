<x-app-layout>
    <x-slot name="maxWidth">max-w-7xl</x-slot>
    
    <div class="flex flex-col md:flex-row gap-12 py-8 px-4" x-data="{ tab: 'profile' }">
        <aside class="w-full md:w-72 flex-shrink-0 space-y-8">
            <div class="space-y-6">
                <div class="space-y-1 mb-8">
                    <h1 class="text-3xl font-black text-white tracking-tight">Paramètres</h1>
                    <p class="text-gray-500 text-sm">Gérez votre compte et vos préférences</p>
                </div>

                <nav class="flex flex-col space-y-1">
                    <button 
                        @click="tab = 'profile'" 
                        :class="tab === 'profile' ? 'bg-white text-black' : 'text-gray-400 hover:text-white'" 
                        class="group flex items-center px-6 py-4 text-sm font-black rounded-2xl w-full text-left transition-all"
                    >
                        {{ __('Profil') }}
                    </button>
                    
                    <button 
                        @click="tab = 'password'" 
                        :class="tab === 'password' ? 'bg-white text-black' : 'text-gray-400 hover:text-white'" 
                        class="group flex items-center px-6 py-4 text-sm font-black rounded-2xl w-full text-left transition-all"
                    >
                        {{ __('Sécurité') }}
                    </button>
                    
                    <div class="border-t border-gray-800 my-4 mx-4"></div>

                    <button 
                        @click="tab = 'delete'" 
                        :class="tab === 'delete' ? 'bg-red-600 text-white' : 'text-red-500 hover:text-red-400'" 
                        class="group flex items-center px-6 py-4 text-sm font-black rounded-2xl w-full text-left transition-all"
                    >
                        {{ __('Désactiver') }}
                    </button>
                </nav>
            </div>
        </aside>

        <div class="flex-1 min-w-0 border-l border-gray-800 pl-0 md:pl-12">
            <div x-show="tab === 'profile'" class="space-y-12">
                <div class="bg-gray-900/40 border border-gray-800 p-8 rounded-3xl">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div x-show="tab === 'password'" style="display: none;" class="space-y-12">
                <div class="bg-gray-900/40 border border-gray-800 p-8 rounded-3xl">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div x-show="tab === 'delete'" style="display: none;" class="space-y-12">
                <div class="bg-red-600/5 border border-red-600/20 p-8 rounded-3xl">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
