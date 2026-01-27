<x-app-layout>
    <x-slot name="maxWidth">max-w-3xl</x-slot>

    <div class="py-12 px-4">
        <a href="{{ route('profile.wall', ['user' => $user->name]) }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-white mb-8 transition-colors group">
            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span class="font-bold text-sm uppercase tracking-widest">Retour au mur</span>
        </a>

        <div class="flex items-center justify-between mb-8">
            <h2 class="text-sm font-black text-gray-500 uppercase tracking-[0.2em]">Abonnés de {{ $user->name }}</h2>
            <div class="h-[1px] flex-1 bg-gray-800 ml-6"></div>
        </div>

        <div class="space-y-4">
            @foreach($users as $follower)
                <div class="bg-gray-900/40 border border-gray-800 p-6 rounded-2xl flex items-center justify-between hover:bg-gray-900/60 transition-all group">
                    <a href="{{ route('profile.wall', ['user' => $follower->name]) }}" class="flex items-center gap-4 flex-1">
                        <div class="w-12 h-12 bg-gray-800 rounded-xl overflow-hidden flex-shrink-0 border border-gray-700">
                            @if($follower->avatar)
                                <img src="{{ asset('storage/' . $follower->avatar) }}" class="w-full h-full object-cover" alt="">
                            @else
                                <svg class="w-full h-full text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-black text-white group-hover:text-blue-400 transition-colors">{{ $follower->name }}</h3>
                            <p class="text-gray-600 text-xs font-mono">@ {{ strtolower(str_replace(' ', '', $follower->name)) }}</p>
                        </div>
                    </a>

                    @if(auth()->id() !== $follower->id)
                        <form action="{{ route('users.follow', $follower) }}" method="POST">
                            @csrf
                            @if(auth()->user()->isFollowing($follower))
                                <button type="submit" class="px-6 py-2 border border-gray-700 text-white rounded-xl font-black hover:border-red-500 hover:text-red-500 transition-all group/btn text-xs uppercase tracking-widest">
                                    <span class="group-hover/btn:hidden">Abonné</span>
                                    <span class="hidden group-hover/btn:inline">Se désabonner</span>
                                </button>
                            @else
                                <button type="submit" class="px-6 py-2 bg-white text-black rounded-xl font-black hover:bg-gray-200 transition-all text-xs uppercase tracking-widest">
                                    Suivre
                                </button>
                            @endif
                        </form>
                    @endif
                </div>
            @endforeach

            @if($users->isEmpty())
                <div class="bg-gray-900/20 border-2 border-dashed border-gray-800 p-12 rounded-3xl text-center">
                    <p class="text-gray-500 text-lg font-medium">Aucun abonné pour le moment.</p>
                </div>
            @endif
        </div>

        <div class="mt-8">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
