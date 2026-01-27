<x-app-layout>
    <x-slot name="maxWidth">max-w-3xl</x-slot>

    <div class="py-12 px-4">
        <h2 class="text-sm font-black text-gray-500 uppercase tracking-[0.2em] mb-8">Notifications</h2>

        <div class="space-y-4">
            @foreach($notifications as $notification)
                @php
                    $type = $notification->data['type'] ?? 'mention';
                @endphp
                <div class="bg-gray-900/40 border border-gray-800 p-6 rounded-2xl flex gap-4 items-start {{ $notification->read_at ? '' : 'border-blue-500/50 bg-blue-900/5' }}">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 
                        {{ $type === 'like' ? 'bg-pink-600/20 text-pink-500' : 'bg-blue-600/20 text-blue-500' }}">
                        @if($type === 'like')
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        @elseif($type === 'reply')
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        @else
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        @endif
                    </div>
                    <div class="flex-1">
                        <p class="text-white text-sm">
                            <span class="font-black">{{ $notification->data['user_name'] }}</span>
                            @if($type === 'like')
                                a aimé votre message.
                            @elseif($type === 'reply')
                                a répondu à votre message.
                            @else
                                vous a cité dans un message.
                            @endif
                        </p>
                        <div class="mt-3 p-4 bg-black/40 rounded-xl border border-gray-800">
                            <p class="text-gray-400 text-sm italic line-clamp-2">"{{ $notification->data['content'] }}"</p>
                        </div>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-[10px] text-gray-600 font-mono">{{ $notification->created_at->diffForHumans() }}</span>
                            <a href="{{ route('messages.show', $notification->data['message_id']) }}" class="text-[10px] font-black text-blue-500 hover:text-blue-400 uppercase tracking-widest">Voir</a>
                        </div>
                    </div>
                </div>
            @endforeach

            @if($notifications->isEmpty())
                <div class="bg-gray-900/20 border-2 border-dashed border-gray-800 p-12 rounded-3xl text-center">
                    <p class="text-gray-500 text-lg font-medium">Aucune notification pour le moment.</p>
                </div>
            @endif
        </div>

        <div class="mt-8">
            {{ $notifications->links() }}
        </div>
    </div>
</x-app-layout>
