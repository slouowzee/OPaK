<x-app-layout>
    <x-slot name="maxWidth">max-w-7xl</x-slot>

    <div class="flex flex-col lg:flex-row gap-12 py-8 px-4">
        <aside class="w-full lg:w-80 flex-shrink-0">
            <div class="sticky top-24 space-y-6">
                <div class="bg-gray-900/40 border border-gray-800 p-6 rounded-3xl">
                    <h2 class="text-sm font-black text-gray-500 uppercase tracking-[0.2em] mb-6">Nouveau Message</h2>
                    
                    <form method="POST" action="{{ route('messages.store') }}" enctype="multipart/form-data" 
                        x-data="{ 
                            content: '',
                            MAX_LENGTH: 140
                        }">
                        @csrf
                        <div class="space-y-4">
                            <textarea 
                                name="content"
                                x-model="content"
                                placeholder="Quoi de neuf ?" 
                                class="w-full bg-black/40 text-white placeholder-gray-600 border border-gray-800 focus:border-blue-500 focus:ring-0 rounded-2xl p-4 h-32 resize-none transition-colors"
                                :maxlength="MAX_LENGTH"    
                            ></textarea>
                            
                            <div class="flex justify-between items-center px-1">
                                <span class="text-[10px] font-mono text-gray-600 font-bold" :class="content.length > 120 ? 'text-orange-500' : ''">
                                    <span x-text="content.length"></span> / <span x-text="MAX_LENGTH"></span>
                                </span>
                                <button type="submit" class="bg-white text-black text-xs font-black py-2 px-6 rounded-xl hover:bg-gray-200 transition-colors disabled:opacity-50" :disabled="!content.trim()">
                                    PUBLIER
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </aside>

        <main class="flex-1 min-w-0 border-l border-gray-800 pl-0 md:pl-12">
            <div class="flex items-center gap-8 mb-8 border-b border-gray-800">
                <a href="{{ route('dashboard', ['feed' => 'all']) }}" class="text-sm font-black uppercase tracking-[0.2em] pb-4 border-b-2 {{ $feed === 'all' ? 'border-white text-white' : 'border-transparent text-gray-500 hover:text-gray-300' }} transition-all">Pour vous</a>
                <a href="{{ route('dashboard', ['feed' => 'following']) }}" class="text-sm font-black uppercase tracking-[0.2em] pb-4 border-b-2 {{ $feed === 'following' ? 'border-white text-white' : 'border-transparent text-gray-500 hover:text-gray-300' }} transition-all">Abonnements</a>
            </div>

            <div class="space-y-6">
                @foreach($messages as $message)
                    <div class="bg-gray-900/40 border border-gray-800/60 rounded-2xl hover:bg-gray-900/60 transition-all group overflow-hidden">
                        <div class="p-6">
                            <div class="flex gap-4">
                                <a href="{{ route('profile.wall', ['username' => $message->user->name]) }}" class="w-12 h-12 bg-gray-800 rounded-xl border border-gray-700 overflow-hidden flex-shrink-0 group-hover:scale-105 transition-transform">
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
                                            <a href="{{ route('profile.wall', ['username' => $message->user->name]) }}" class="font-black text-white hover:text-blue-400 transition-colors truncate">
                                                {{ $message->user->name }}
                                            </a>
                                            <span class="text-gray-600 text-[11px] font-mono">@ {{ strtolower(str_replace(' ', '', $message->user->name)) }} · {{ $message->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>

                                    <a href="{{ route('messages.show', $message) }}" class="block">
                                        <p class="text-gray-200 text-lg leading-snug mb-4">
                                            {{ $message->content }}
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
                        <p class="text-gray-500 text-lg font-medium">Aucun message pour le moment.</p>
                    </div>
                @endif
            </div>
        </main>
    </div>
</x-app-layout>
