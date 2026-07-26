<x-seller-layout title="Pesan">

    <div class="bg-white shadow-md rounded-lg p-6">
        <ul role="list" class="divide-y divide-gray-100">
            @forelse ($conversations as $conversation)
                <li>
                    <a href="{{ route('messages.show', ['vehicle' => $conversation->vehicle, 'otherUserId' => $conversation->otherUser->id]) }}"
                       class="flex justify-between gap-x-6 py-5 hover:bg-gray-50 -mx-2 px-2 rounded-lg">
                        <div class="flex min-w-0 gap-x-4">
                            <x-avatar :user="$conversation->otherUser" size="lg" />
                            <div class="min-w-0 flex-auto">
                                <p class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                    {{ $conversation->otherUser->name }}
                                    @if ($conversation->unreadCount > 0)
                                        <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-indigo-600 text-white text-[10px] font-bold">
                                            {{ $conversation->unreadCount }}
                                        </span>
                                    @endif
                                </p>
                                <p class="mt-1 text-xs text-gray-500">{{ $conversation->otherUser->email }}</p>
                                <p class="mt-1 text-xs text-gray-400 truncate max-w-md">
                                    {{ \Illuminate\Support\Str::limit($conversation->lastMessage->body, 60) }}
                                </p>
                            </div>
                        </div>
                        <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                            <p class="text-sm text-gray-900">{{ $conversation->vehicle->title }}</p>
                            <p class="mt-1 text-xs text-gray-500">
                                {{ $conversation->lastMessage->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </a>
                </li>
            @empty
                <li class="py-10 text-center text-gray-400 text-sm">
                    Belum ada percakapan.
                </li>
            @endforelse
        </ul>
    </div>
</x-seller-layout>