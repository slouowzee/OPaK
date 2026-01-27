<x-app-layout>
    <x-slot name="maxWidth">max-w-7xl</x-slot>

    <div class="flex flex-col lg:flex-row gap-12 py-8 px-4">
        <aside class="w-full lg:w-80 flex-shrink-0">
            <div class="sticky top-24 space-y-6">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-white mb-4 transition-colors group">
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    <span class="font-bold text-sm uppercase tracking-widest">Retour au flux</span>
                </a>

                <div class="bg-gray-900/40 border border-gray-800 p-6 rounded-3xl">
                    <h2 class="text-sm font-black text-gray-500 uppercase tracking-[0.2em] mb-6">Répondre</h2>
                    
                    <form method="POST" action="{{ route('messages.store') }}" 
                        x-data="{ 
                            content: '',
                            MAX_LENGTH: 140
                        }">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $message->id }}">
                        <div class="space-y-4">
                            <textarea 
                                name="content"
                                x-model="content"
                                placeholder="Postez votre réponse" 
                                class="w-full bg-black/40 text-white placeholder-gray-600 border border-gray-800 focus:border-blue-500 focus:ring-0 rounded-2xl p-4 h-32 resize-none transition-colors"
                                :maxlength="MAX_LENGTH"    
                            ></textarea>
                            
                            <div class="flex justify-between items-center px-1">
                                <span class="text-[10px] font-mono text-gray-600 font-bold" :class="content.length > 120 ? 'text-orange-500' : ''">
                                    <span x-text="content.length"></span> / <span x-text="MAX_LENGTH"></span>
                                </span>
                                <button type="submit" class="bg-blue-600 text-white text-xs font-black py-2 px-6 rounded-xl hover:bg-blue-700 transition-colors disabled:opacity-50" :disabled="!content.trim()">
                                    RÉPONDRE
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </aside>

        <main class="flex-1 min-w-0 border-l border-gray-800 pl-0 md:pl-12">
            <div class="bg-gray-900/40 border border-gray-800 p-8 rounded-3xl space-y-6 mb-12">
                <div class="flex items-center gap-4">
                    <a href="{{ route('profile.wall', ['username' => $message->user->name]) }}" class="w-14 h-14 bg-gray-800 rounded-2xl border border-gray-700 overflow-hidden flex-shrink-0">
                        @if($message->user->avatar)
                            <img src="{{ asset('storage/' . $message->user->avatar) }}" class="w-full h-full object-cover" alt="">
                        @else
                            <svg class="w-full h-full text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        @endif
                    </a>
                    <div>
                        <h2 class="text-xl font-black text-white leading-tight">{{ $message->user->name }}</h2>
                        <p class="text-blue-500 font-mono text-sm">@ {{ strtolower(str_replace(' ', '', $message->user->name)) }}</p>
                    </div>
                </div>

                <p class="text-gray-100 text-2xl leading-relaxed font-medium">
                    {!! $message->content_formatted !!}
                </p>

                <div class="pt-6 border-t border-gray-800 flex justify-between items-center text-gray-500 text-sm">
                    <span class="font-mono">{{ $message->created_at->translatedFormat('H:i · d M Y') }}</span>
                    <div class="flex gap-6">
                        <form action="{{ route('messages.like', $message) }}" method="POST">
                            @csrf
                            <button type="submit" class="hover:text-pink-500 transition-colors flex items-center gap-2 {{ $message->isLikedBy(auth()->user()) ? 'text-pink-500' : '' }}">
                                <svg class="w-6 h-6" fill="{{ $message->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                <span class="text-base font-mono">{{ $message->likes()->count() }}</span>
                            </button>
                        </form>
                        <button class="hover:text-blue-500 transition-colors flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            <span class="text-base font-mono">{{ $message->replies()->count() }}</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="flex items-center gap-4 mb-8">
                    <h3 class="text-xs font-black text-gray-500 uppercase tracking-widest">Réponses</h3>
                    <div class="h-[1px] flex-1 bg-gray-800"></div>
                </div>

                @foreach($message->replies as $reply)
                    <div class="bg-gray-900/20 border border-gray-800/60 p-6 rounded-2xl group">
                        <div class="flex gap-4">
                            <a href="{{ route('profile.wall', ['username' => $reply->user->name]) }}" class="w-10 h-10 bg-gray-800 rounded-xl border border-gray-700 overflow-hidden flex-shrink-0">
                                @if($reply->user->avatar)
                                    <img src="{{ asset('storage/' . $reply->user->avatar) }}" class="w-full h-full object-cover" alt="">
                                @else
                                    <svg class="w-full h-full text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                @endif
                            </a>
                            <div class="flex-1">
                                <div class="flex justify-between items-start mb-1">
                                    <div class="flex flex-col">
                                        <span class="font-black text-white text-sm">{{ $reply->user->name }}</span>
                                        <span class="text-gray-600 text-[10px] font-mono">@ {{ strtolower(str_replace(' ', '', $reply->user->name)) }} · {{ $reply->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <p class="text-gray-300 text-base leading-relaxed">
                                    {!! $reply->content_formatted !!}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if($message->replies->isEmpty())
                    <div class="bg-gray-900/10 border-2 border-dashed border-gray-800/50 p-12 rounded-3xl text-center">
                        <p class="text-gray-600 text-sm font-medium uppercase tracking-widest">Soyez le premier à répondre</p>
                    </div>
                @endif
            </div>
        </main>
    </div>
</x-app-layout>
