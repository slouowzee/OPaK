<x-app-layout>
    <x-slot name="maxWidth">max-w-5xl</x-slot>
    
    <div class="flex flex-col md:flex-row gap-8 py-6" x-data="{ tab: 'profile' }">
        <!-- Sidebar -->
        <aside class="w-full md:w-64 flex-shrink-0">
            <nav class="flex flex-col space-y-1">
                <button 
                    @click="tab = 'profile'" 
                    :class="tab === 'profile' ? 'text-blue-500' : 'text-gray-400'" 
                    class="group flex items-center px-4 py-3 text-sm font-bold w-full text-left"
                >
                    {{ __('Vos informations') }}
                </button>
                
                <button 
                    @click="tab = 'password'" 
                    :class="tab === 'password' ? 'text-blue-500' : 'text-gray-400'" 
                    class="group flex items-center px-4 py-3 text-sm font-bold w-full text-left"
                >
                    {{ __('Modifier MDP') }}
                </button>
                
                <div class="border-t border-gray-800 my-2 mx-4"></div>

                <button 
                    @click="tab = 'delete'" 
                    :class="tab === 'delete' ? 'text-red-500' : 'text-red-500'" 
                    class="group flex items-center px-4 py-3 text-sm font-bold w-full text-left"
                >
                    {{ __('Désactiver votre compe') }}
                </button>
            </nav>
        </aside>

        <!-- Main Tab -->
        <div class="flex-1 min-w-0 border-l border-gray-800 pl-0 md:pl-8">
            <!-- Profile Info Tab -->
            <div x-show="tab === 'profile'">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Password Tab -->
            <div x-show="tab === 'password'" style="display: none;">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Tab -->
            <div x-show="tab === 'delete'" style="display: none;">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
