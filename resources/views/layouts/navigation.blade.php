<nav class="border-b border-gray-800 bg-black sticky top-0 z-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-2xl font-black text-white tracking-widest">
                        OPaK
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('dashboard') ? 'border-white text-white' : 'border-transparent text-gray-500 hover:text-gray-300 hover:border-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                        Accueil
                    </a>
                    <a href="{{ route('search') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('search') ? 'border-white text-white' : 'border-transparent text-gray-500 hover:text-gray-300 hover:border-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                        Rechercher
                    </a>
					<a href="{{ route('notifications') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('notifications') ? 'border-white text-white' : 'border-transparent text-gray-500 hover:text-gray-300 hover:border-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out relative">
                        Notifications
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute top-3 -right-2 flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                            </span>
                        @endif
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                    <div @click="open = ! open">
                         <button class="flex items-center gap-2 text-sm font-medium {{ request()->routeIs('profile.*') ? 'text-white' : 'text-gray-500 hover:text-gray-300' }} focus:outline-none transition duration-150 ease-in-out cursor-pointer">
                            <div class="w-8 h-8 rounded-lg overflow-hidden bg-gray-800 border border-gray-700">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover" alt="">
                                @else
                                    <svg class="w-full h-full text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                @endif
                            </div>
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </div>

                    <div x-show="open" 
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 z-50 mt-2 w-52 rounded-lg border border-gray-800 bg-black py-2 shadow-xl origin-top-right" 
                         style="display: none;">
                        <a href="{{ route('profile.wall', ['username' => Auth::user()->name]) }}" class="block px-4 py-2 text-sm font-semibold text-white hover:bg-gray-900">
                            Votre page
                        </a>
						<a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm font-semibold text-white hover:bg-gray-900">
                            Vos informations
                        </a>
                        <div class="border-t border-gray-800 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                             @csrf
                             <button type="submit" class="block w-full text-left px-4 py-2 text-sm font-semibold text-white hover:bg-gray-900">
                                 Déconnexion
                             </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>
