<x-app-layout>
    <x-slot name="maxWidth">max-w-7xl</x-slot>
    <div class="flex flex-col md:flex-row gap-12 py-8 px-4">
        
        <!-- Left Sidebar: Profile Identity -->
        <aside class="w-full md:w-72 flex-shrink-0 space-y-8">
            <div class="space-y-6">
                <!-- Large Avatar -->
                <div class="w-40 h-40 bg-gray-800 rounded-2xl border border-gray-700 overflow-hidden shadow-2xl">
                    <svg class="w-full h-full text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>

                <!-- Identity Info -->
                <div class="space-y-1">
                    <h1 class="text-3xl font-black text-white tracking-tight">{{ $user->name }}</h1>
                    <p class="text-blue-500 font-mono text-sm">@ {{ strtolower(str_replace(' ', '', $user->name)) }}</p>
                </div>

                <!-- Stats Bento-ish Style -->
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-gray-900 border border-gray-800 p-3 rounded-xl">
                        <span class="block text-xl font-black text-white">{{ $user->followings()->count() }}</span>
                        <span class="text-xs text-gray-500 uppercase font-bold tracking-widest">Suivis</span>
                    </div>
                    <div class="bg-gray-900 border border-gray-800 p-3 rounded-xl">
                        <span class="block text-xl font-black text-white">{{ $user->followers()->count() }}</span>
                        <span class="text-xs text-gray-500 uppercase font-bold tracking-widest">Abonnés</span>
                    </div>
                </div>

                <!-- Meta Info -->
                <div class="space-y-3 text-gray-400 text-sm border-t border-gray-800 pt-6">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Membre depuis {{ $user->created_at->translatedFormat('F Y') }}
                    </div>
                </div>

                <!-- Action Button -->
                <div class="pt-4">
                    @if(Auth::id() === $user->id)
                        <a href="{{ route('profile.edit') }}" class="block w-full text-center px-6 py-3 bg-white text-black rounded-xl font-black hover:bg-gray-200 transition-all">
                            Paramètres
                        </a>
                    @else
                        <button class="block w-full text-center px-6 py-3 bg-blue-600 text-white rounded-xl font-black hover:bg-blue-700 transition-all shadow-lg shadow-blue-900/20">
                            Suivre
                        </button>
                    @endif
                </div>
            </div>
        </aside>

        <!-- Main Content: Feed -->
        <main class="flex-1 min-w-0 border-l border-gray-800 pl-0 md:pl-12">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-sm font-black text-gray-500 uppercase tracking-[0.2em]">Activités Récentes</h2>
                <div class="h-[1px] flex-1 bg-gray-800 ml-6"></div>
            </div>

            <div class="space-y-6">
                @foreach($messages as $message)
                    <div class="bg-gray-900/40 border border-gray-800/60 p-6 rounded-2xl hover:bg-gray-900/60 transition-all group">
                        <div class="flex flex-col gap-4">
                            <div class="flex justify-between items-start">
                                <span class="text-xs text-gray-500 font-mono">{{ $message->created_at->diffForHumans() }}</span>
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button class="text-gray-600 hover:text-white">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                                    </button>
                                </div>
                            </div>
                            <p class="text-gray-100 text-lg leading-relaxed">
                                {{ $message->content }}
                            </p>
                            <div class="flex items-center gap-4 pt-2 text-gray-500">
                                <button class="hover:text-pink-500 transition-colors flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                    <span class="text-sm font-mono">{{ $message->likes_count ?? 0 }}</span>
                                </button>
                                <button class="hover:text-blue-500 transition-colors flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                    <span class="text-sm font-mono">0</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if($messages->isEmpty())
                    <div class="bg-gray-900/20 border-2 border-dashed border-gray-800 p-12 rounded-3xl text-center">
                        <p class="text-gray-500 text-lg font-medium">Ce mur est encore vierge de toute pensée.</p>
                    </div>
                @endif
            </div>
        </main>
    </div>
</x-app-layout>
