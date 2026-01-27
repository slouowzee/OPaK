<x-app-layout>
    <x-slot name="maxWidth">max-w-[1400px]</x-slot>

    <div class="flex flex-col md:flex-row gap-12 py-12 px-4">
        <!-- Barre latérale : Carte d'identité avec bannière intégrée -->
        <aside class="w-full md:w-96 flex-shrink-0">
            <div class="sticky top-24">
                <div class="relative mb-12">
                    <!-- Zone de la bannière -->
                    <div class="h-48 w-full bg-gray-800 rounded-xl overflow-hidden border border-gray-700">
                        @if($user->banner)
                            <img src="{{ asset('storage/' . $user->banner) }}" class="w-full h-full object-cover" alt="">
                        @endif
                    </div>
                    
                    <!-- Zone de contenu avec avatar superposé -->
                    <div class="absolute -bottom-8 left-8">
                        <div class="w-24 h-24 md:w-32 md:h-32 bg-gray-800 rounded-2xl border-4 border-black overflow-hidden shadow-2xl">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover" alt="">
                            @else
                                <svg class="w-full h-full text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="px-4 space-y-6">
                    <div class="space-y-1">
                        <h1 class="text-3xl font-black text-white tracking-tight leading-none">{{ $user->name }}</h1>
                        <p class="text-blue-500 font-mono text-sm">@ {{ strtolower(str_replace(' ', '', $user->name)) }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('profile.followings', ['user' => $user->name]) }}" class="bg-gray-900/50 border border-gray-800/50 p-4 rounded-2xl text-center hover:bg-gray-900 transition-colors">
                        <span class="block text-xl font-black text-white leading-none">{{ $user->followings()->count() }}</span>
                        <span class="text-[10px] text-gray-500 uppercase font-bold tracking-widest mt-2 block">Suivis</span>
                    </a>
                    <a href="{{ route('profile.followers', ['user' => $user->name]) }}" class="bg-gray-900/50 border border-gray-800/50 p-4 rounded-2xl text-center hover:bg-gray-900 transition-colors">
                        <span class="block text-xl font-black text-white leading-none">{{ $user->followers()->count() }}</span>
                        <span class="text-[10px] text-gray-500 uppercase font-bold tracking-widest mt-2 block">Abonnés</span>
                    </a>

                    <div class="flex items-center gap-3 text-gray-400 text-xs font-medium">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Membre depuis {{ $user->created_at->translatedFormat('F Y') }}
                    </div>

                    <div class="pt-2">
                        @if(Auth::id() === $user->id)
                            <a href="{{ route('profile.edit') }}" class="block w-full text-center px-6 py-4 bg-white text-black rounded-2xl font-black hover:bg-gray-200 transition-all text-sm uppercase tracking-widest">
                                Paramètres
                            </a>
                        @else
                            <form action="{{ route('users.follow', $user) }}" method="POST">
                                @csrf
                                @if(auth()->user()->isFollowing($user))
                                    <button type="submit" class="block w-full text-center px-6 py-4 border border-gray-700 text-white rounded-2xl font-black hover:border-red-500 hover:text-red-500 transition-all group text-sm uppercase tracking-widest">
                                        <span class="group-hover:hidden">Abonné</span>
                                        <span class="hidden group-hover:inline">Se désabonner</span>
                                    </button>
                                @else
                                    <button type="submit" class="block w-full text-center px-6 py-4 bg-white text-black rounded-2xl font-black hover:bg-gray-200 transition-all text-sm uppercase tracking-widest">
                                        Suivre
                                    </button>
                                @endif
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </aside>

        <!-- Flux principal -->
        <main class="flex-1 min-w-0">
            <div class="flex items-center gap-8 mb-10 border-b border-gray-800/50">
                <button data-tab="messages" class="text-xs font-black uppercase tracking-[0.3em] pb-6 border-b-2 border-white text-white transition-all">Messages</button>
                <button data-tab="replies" class="text-xs font-black uppercase tracking-[0.3em] pb-6 border-b-2 border-transparent text-gray-500 hover:text-gray-300 transition-all">Réponses</button>
            </div>

            <div data-section="messages" class="space-y-6">
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
                            <a href="{{ route('messages.show', $message) }}" class="block">
                                <p class="text-gray-100 text-lg leading-relaxed">
                                    {!! $message->content_formatted !!}
                                </p>
                            </a>
                            <div class="flex items-center gap-4 pt-2 text-gray-500">
                                <form action="{{ route('messages.like', $message) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="hover:text-pink-500 transition-colors flex items-center gap-2 {{ $message->isLikedBy(auth()->user()) ? 'text-pink-500' : '' }}">
                                        <svg class="w-5 h-5" fill="{{ $message->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                        <span class="text-sm font-mono">{{ $message->likes()->count() }}</span>
                                    </button>
                                </form>
                                <a href="{{ route('messages.show', $message) }}" class="hover:text-blue-500 transition-colors flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                    <span class="text-sm font-mono">{{ $message->replies()->count() }}</span>
                                </a>
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

            <div data-section="replies" class="space-y-6 hidden">
                @foreach($replies as $reply)
                    <div class="bg-gray-900/40 border border-gray-800/60 p-6 rounded-2xl hover:bg-gray-900/60 transition-all group">
                        <div class="flex flex-col gap-4">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-mono text-gray-500 mb-2 uppercase tracking-widest">En réponse à <a href="{{ route('profile.wall', ['user' => $reply->parent->user->name]) }}" class="text-blue-500 hover:underline">@ {{ strtolower(str_replace(' ', '', $reply->parent->user->name)) }}</a></span>
                                <a href="{{ route('messages.show', $reply) }}" class="block">
                                    <p class="text-gray-100 text-lg leading-relaxed">
                                        {!! $reply->content_formatted !!}
                                    </p>
                                </a>
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                <span class="text-xs text-gray-600 font-mono">{{ $reply->created_at->diffForHumans() }}</span>
                                <div class="flex items-center gap-4 text-gray-500">
                                    <form action="{{ route('messages.like', $reply) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="hover:text-pink-500 transition-colors flex items-center gap-2 {{ $reply->isLikedBy(auth()->user()) ? 'text-pink-500' : '' }}">
                                            <svg class="w-4 h-4" fill="{{ $reply->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                            <span class="text-xs font-mono">{{ $reply->likes()->count() }}</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if($replies->isEmpty())
                    <div class="bg-gray-900/20 border-2 border-dashed border-gray-800 p-12 rounded-3xl text-center">
                        <p class="text-gray-500 text-lg font-medium">Aucune réponse pour le moment.</p>
                    </div>
                @endif
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('[data-tab]');
            const sections = document.querySelectorAll('[data-section]');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const target = tab.getAttribute('data-tab');
                    
                    tabs.forEach(t => {
                        t.classList.remove('text-white', 'border-white');
                        t.classList.add('text-gray-500', 'border-transparent');
                    });
                    tab.classList.add('text-white', 'border-white');
                    tab.classList.remove('text-gray-500', 'border-transparent');

                    sections.forEach(s => {
                        if (s.getAttribute('data-section') === target) {
                            s.classList.remove('hidden');
                        } else {
                            s.classList.add('hidden');
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>
