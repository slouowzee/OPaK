<x-app-layout>
    <x-slot name="maxWidth">max-w-7xl</x-slot>

    <div class="flex flex-col lg:flex-row gap-12 py-8 px-4">
        <!-- Barre latérale : Formulaire de recherche -->
        <aside class="w-full lg:w-80 flex-shrink-0">
            <div class="sticky top-24 space-y-6">
                <div class="bg-gray-900/40 border border-gray-800 p-6 rounded-3xl">
                    <h2 class="text-sm font-black text-gray-500 uppercase tracking-[0.2em] mb-6">Recherche</h2>
                    
                    <form method="GET" action="{{ route('search') }}" class="space-y-4">
                        <div class="relative">
                            <input 
                                type="text" 
                                name="q" 
                                value="{{ $query }}"
                                placeholder="Utilisateurs, mots clés..." 
                                class="w-full bg-black/40 text-white placeholder-gray-600 border border-gray-800 focus:border-blue-500 focus:ring-0 rounded-2xl p-4 transition-colors"
                                autofocus
                            >
                        </div>
                        <button type="submit" class="w-full bg-white text-black text-xs font-black py-3 rounded-xl hover:bg-gray-200 transition-colors">
                            RECHERCHER
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Flux principal : Résultats -->
        <main class="flex-1 min-w-0 border-l border-gray-800 pl-0 md:pl-12">
            @if($query)
                <div class="mb-12">
                    <h2 class="text-sm font-black text-gray-500 uppercase tracking-[0.2em] mb-8">Utilisateurs</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($users as $user)
                            <a href="{{ route('profile.wall', ['user' => $user->name]) }}" class="bg-gray-900/40 border border-gray-800 p-4 rounded-2xl flex items-center gap-4 hover:bg-gray-900/60 transition-all group">
                                <div class="w-12 h-12 bg-gray-800 rounded-xl overflow-hidden flex-shrink-0 border border-gray-700">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover" alt="">
                                    @else
                                        <svg class="w-full h-full text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-black text-white group-hover:text-blue-400 transition-colors">{{ $user->name }}</h3>
                                    <p class="text-gray-600 text-xs font-mono">@ {{ strtolower(str_replace(' ', '', $user->name)) }}</p>
                                </div>
                            </a>
                        @endforeach
                        @if($users->isEmpty())
                            <p class="text-gray-600 text-sm italic">Aucun utilisateur trouvé.</p>
                        @endif
                    </div>
                </div>

                <div>
                    <h2 class="text-sm font-black text-gray-500 uppercase tracking-[0.2em] mb-8">Messages</h2>
                    <div class="space-y-6">
                        @foreach($messages as $message)
                            <div class="bg-gray-900/40 border border-gray-800/60 rounded-2xl hover:bg-gray-900/60 transition-all group overflow-hidden">
                                <div class="p-6">
                                    <div class="flex gap-4">
                                        <a href="{{ route('profile.wall', ['user' => $message->user->name]) }}" class="w-12 h-12 bg-gray-800 rounded-xl border border-gray-700 overflow-hidden flex-shrink-0 group-hover:scale-105 transition-transform">
                                            @if($message->user->avatar)
                                                <img src="{{ asset('storage/' . $message->user->avatar) }}" class="w-full h-full object-cover" alt="">
                                            @else
                                                <svg class="w-full h-full text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                            @endif
                                        </a>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex justify-between items-start mb-2">
                                                <div class="flex flex-col">
                                                    <a href="{{ route('profile.wall', ['user' => $message->user->name]) }}" class="font-black text-white hover:text-blue-400 transition-colors truncate">
                                                        {{ $message->user->name }}
                                                    </a>
                                                    <span class="text-gray-600 text-[11px] font-mono">@ {{ strtolower(str_replace(' ', '', $message->user->name)) }} · {{ $message->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                            <a href="{{ route('messages.show', $message) }}" class="block">
                                                <p class="text-gray-200 text-lg leading-snug mb-4">
                                                    {!! $message->content_formatted !!}
                                                </p>
                                            </a>
                                            <div class="flex items-center gap-6 text-gray-500">
                                                <form action="{{ route('messages.like', $message) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="hover:text-pink-500 transition-colors flex items-center gap-2 {{ $message->isLikedBy(auth()->user()) ? 'text-pink-500' : '' }}">
                                                        <svg class="w-5 h-5" fill="{{ $message->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                                        <span class="text-xs font-mono">{{ $message->likes()->count() }}</span>
                                                    </button>
                                                </form>
                                                <a href="{{ route('messages.show', $message) }}" class="hover:text-blue-500 transition-colors flex items-center gap-2">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                                    <span class="text-xs font-mono">{{ $message->replies()->count() }}</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if($messages->isEmpty())
                            <div class="bg-gray-900/20 border-2 border-dashed border-gray-800 p-12 rounded-3xl text-center">
                                <p class="text-gray-500 text-lg font-medium">Aucun message ne correspond à votre recherche.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="h-[60vh] flex flex-col items-center justify-center text-center">
                    <div class="w-24 h-24 bg-gray-900 rounded-3xl flex items-center justify-center mb-6 border border-gray-800">
                        <svg class="w-12 h-12 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <h2 class="text-2xl font-black text-white mb-2">Lancez une recherche</h2>
                    <p class="text-gray-500 max-w-xs">Trouvez des personnes à suivre ou des sujets qui vous intéressent.</p>
                </div>
            @endif
        </main>
    </div>
</x-app-layout>
