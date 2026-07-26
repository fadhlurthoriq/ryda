<x-seller-layout title="Chat">

    <div class="bg-white shadow-md rounded-lg overflow-hidden flex flex-col" style="height: calc(100vh - 8rem);">

        <!-- Header percakapan -->
        <div class="flex items-center gap-3 px-5 py-4 border-b">
            <a href="{{ route('messages.index') }}" class="text-gray-400 hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <x-avatar :user="$otherUser" size="md" />
            <div class="min-w-0">
                <p class="text-sm font-semibold text-gray-900">{{ $otherUser->name }}</p>
                <p class="text-xs text-gray-500 truncate">{{ $vehicle->title }}</p>
            </div>
            <a href="{{ route('vehicles.show', $vehicle) }}"
               class="ml-auto text-xs text-indigo-600 hover:underline flex-shrink-0">
                Lihat Iklan
            </a>
        </div>

        <!-- Riwayat pesan -->
        <div class="flex-1 overflow-y-auto px-5 py-4 space-y-3 bg-gray-50" id="chat-messages">
            @forelse ($messages as $message)
                @php $isMine = $message->sender_id === Auth::id(); @endphp
                <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-xs sm:max-w-sm">
                        <div class="px-4 py-2 rounded-2xl text-sm
                            {{ $isMine ? 'bg-indigo-600 text-white rounded-br-sm' : 'bg-white border text-gray-800 rounded-bl-sm' }}">
                            {{ $message->body }}
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1 {{ $isMine ? 'text-right' : 'text-left' }}">
                            {{ $message->created_at->format('H:i') }}
                        </p>
                    </div>
                </div>
            @empty
                <p class="text-center text-sm text-gray-400 py-10">Belum ada pesan. Mulai percakapan!</p>
            @endforelse
        </div>

        <!-- Form kirim pesan -->
        <form action="{{ route('messages.store', $vehicle) }}" method="POST" class="flex items-center gap-3 px-5 py-4 border-t">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $otherUser->id }}">
            <input type="text" name="body" required autocomplete="off"
                   class="flex-1 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-2.5"
                   placeholder="Tulis pesan...">
            <button type="submit"
                    class="text-white bg-indigo-600 hover:bg-indigo-700 font-medium rounded-lg text-sm px-4 py-2.5 flex-shrink-0">
                Kirim
            </button>
        </form>
    </div>
</x-seller-layout>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const chatBox = document.getElementById('chat-messages');
        chatBox.scrollTop = chatBox.scrollHeight;

        const userIds = [{{ auAuth::id() }}, {{ $otherUser->id }}].sort((a, b) => a - b);
        const channelName = `chat.{{ $vehicle->id }}.${userIds.join('-')}`;

        window.Echo.private(channelName)
            .listen('.message.sent', (e) => {
                const isMine = e.sender_id === {{ Auth::id() }};

                const wrapper = document.createElement('div');
                wrapper.className = `flex ${isMine ? 'justify-end' : 'justify-start'}`;

                wrapper.innerHTML = `
                    <div class="max-w-xs sm:max-w-sm">
                        <div class="px-4 py-2 rounded-2xl text-sm ${isMine ? 'bg-indigo-600 text-white rounded-br-sm' : 'bg-white border text-gray-800 rounded-bl-sm'}">
                            ${e.body}
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1 ${isMine ? 'text-right' : 'text-left'}">
                            ${e.created_at}
                        </p>
                    </div>
                `;

                chatBox.appendChild(wrapper);
                chatBox.scrollTop = chatBox.scrollHeight;
            });
    });
</script>