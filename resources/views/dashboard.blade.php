<x-app-layout>
    <!-- Create Post Form -->
    <div class="border-b border-gray-800 p-4">
        <form method="POST" action="{{ route('messages.store') }}">
            @csrf
            <div class="flex gap-4">
                <div class="w-12 h-12 bg-gray-700 rounded-full flex-shrink-0 overflow-hidden">
                    <svg class="w-full h-full text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <textarea 
                        name="content"
                        placeholder="Quoi de neuf ?" 
                        class="w-full bg-transparent text-xl text-white placeholder-gray-500 border-none focus:ring-0 resize-none h-24"
                        maxlength="140"    
                    ></textarea>
                    
                    @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <div class="flex justify-between items-center mt-2 border-t border-gray-800 pt-3">
                        <div class="flex gap-2 text-blue-400">
                           <!-- Icons for media (fake for now) -->
                           <button type="button" class="hover:bg-blue-900/30 p-2 rounded-full">📷</button>
                           <button type="button" class="hover:bg-blue-900/30 p-2 rounded-full">📊</button>
                           <button type="button" class="hover:bg-blue-900/30 p-2 rounded-full">😀</button>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-full disabled:opacity-50">
                            Poster
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Feed -->
    <div>
        @foreach($messages as $message)
            <div class="border-b border-gray-800 p-4 hover:bg-gray-900/50 transition cursor-pointer">
                <div class="flex gap-4">
                    <div class="w-12 h-12 bg-gray-700 rounded-full flex-shrink-0 overflow-hidden">
                        <svg class="w-full h-full text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-bold text-white">{{ $message->user->name }}</span>
                            <span class="text-gray-500 text-sm">@ {{ strtolower(str_replace(' ', '', $message->user->name)) }}</span>
                            <span class="text-gray-500 text-sm">·</span>
                            <span class="text-gray-500 text-sm hover:underline">{{ $message->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-200 text-base leading-snug">
                            {{ $message->content }}
                        </p>
                        
                        <!-- Post Actions -->
                        <div class="flex justify-between max-w-md mt-3 text-gray-500">
                             <button class="flex items-center gap-2 hover:text-blue-400 group">
                                <span class="group-hover:bg-blue-900/30 p-2 rounded-full transition">💬</span>
                                <span class="text-sm">0</span>
                             </button>
                             <button class="flex items-center gap-2 hover:text-green-400 group">
                                <span class="group-hover:bg-green-900/30 p-2 rounded-full transition">🔄</span>
                                <span class="text-sm">0</span>
                             </button>
                             <button class="flex items-center gap-2 hover:text-pink-400 group">
                                <span class="group-hover:bg-pink-900/30 p-2 rounded-full transition">❤️</span>
                                <span class="text-sm">0</span>
                             </button>
                             <button class="flex items-center gap-2 hover:text-blue-400 group">
                                <span class="group-hover:bg-blue-900/30 p-2 rounded-full transition">📊</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @if($messages->isEmpty())
            <div class="p-8 text-center text-gray-500">
                <p class="text-xl mb-2">C'est un peu vide ici...</p>
                <p>Soyez le premier à poster quelque chose !</p>
            </div>
        @endif
    </div>
</x-app-layout>
