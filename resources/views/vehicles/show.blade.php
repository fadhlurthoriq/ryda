<x-seller-layout title="Detail Iklan">

    <div x-data="{ activeImage: 0, total: {{ $vehicle->images->count() ?: 1 }} }"
         class="bg-white shadow-md rounded-lg p-6">

        <h1 class="text-2xl font-bold text-gray-900">{{ $vehicle->title }}</h1>
        <p class="text-xl font-semibold text-amber-600 mt-1">
            Rp. {{ number_format($vehicle->price, 0, ',', '.') }}
        </p>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-5">

            <!-- Foto hero + arrow -->
            <div class="lg:col-span-2">
                <div class="relative bg-gray-100 rounded-lg overflow-hidden aspect-video">
                    @forelse ($vehicle->images as $index => $image)
                        <img x-show="activeImage === {{ $index }}"
                             src="{{ asset('storage/' . $image->path) }}"
                             alt="{{ $vehicle->title }}"
                             class="w-full h-full object-cover">
                    @empty
                        <img src="https://placehold.co/800x450?text=Belum+Ada+Foto"
                             alt="Belum ada foto"
                             class="w-full h-full object-cover">
                    @endforelse

                    @if ($vehicle->images->count() > 1)
                        <button type="button"
                                @click="activeImage = (activeImage - 1 + total) % total"
                                class="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/80 hover:bg-white flex items-center justify-center shadow">
                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button type="button"
                                @click="activeImage = (activeImage + 1) % total"
                                class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/80 hover:bg-white flex items-center justify-center shadow">
                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    @endif
                </div>

                <!-- Deskripsi -->
                <div class="mt-6">
                    <h2 class="text-sm font-semibold text-gray-900 mb-2">Deskripsi</h2>
                    <p class="text-sm text-gray-700 whitespace-pre-line leading-relaxed">{{ $vehicle->description }}</p>
                </div>
            </div>

            <!-- Info detail -->
            <div class="lg:col-span-1 space-y-5">
                <div>
                    <p class="text-sm font-semibold text-gray-900">Status</p>
                    <span class="inline-block mt-1 text-xs px-2 py-1 rounded-full
                        {{ $vehicle->status === 'tersedia' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-500' }}">
                        {{ ucfirst($vehicle->status) }}
                    </span>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-900">Kategori</p>
                    <p class="text-sm text-gray-600 mt-0.5">{{ $vehicle->category->name }}</p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-900">Merek/Model</p>
                    <p class="text-sm text-gray-600 mt-0.5">{{ $vehicle->model }} {{ $vehicle->brand }}</p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-900">Tahun</p>
                    <p class="text-sm text-gray-600 mt-0.5">{{ $vehicle->year }}</p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-900">Kondisi</p>
                    <p class="text-sm text-gray-600 mt-0.5">{{ ucfirst($vehicle->condition) }}</p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-900">Lokasi</p>
                    <p class="text-sm text-gray-600 mt-0.5">{{ $vehicle->location }}</p>
                </div>
            </div>
        </div>

        <!-- Aksi -->
        <div class="flex items-center justify-between mt-8 pt-5 border-t">
            <a href="{{ route('vehicles.my-vehicles') }}"
               class="flex items-center gap-2 text-gray-700 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg text-sm px-4 py-2.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>

            @if (auth()->id() === $vehicle->user_id && $vehicle->status === 'tersedia')
                <div class="flex items-center gap-3">
                    <a href="{{ route('vehicles.edit', $vehicle) }}"
                       class="flex items-center gap-2 text-white bg-indigo-600 hover:bg-indigo-700 font-medium rounded-lg text-sm px-4 py-2.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </a>

                    <form id="delete-vehicle-{{ $vehicle->id }}" action="{{ route('vehicles.destroy', $vehicle) }}" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                    <button type="button"
                            onclick="confirmDeleteVehicle({{ $vehicle->id }})"
                            class="flex items-center gap-2 text-white bg-red-600 hover:bg-red-700 font-medium rounded-lg text-sm px-4 py-2.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus
                    </button>
                </div>
            @endif
            @if (auth()->id() !== $vehicle->user_id)
    <div x-data="{ showMessageForm: false }">
        <div class="flex items-center gap-3">
            @if ($vehicle->status === 'tersedia')
                <form action="{{ route('transactions.store', $vehicle) }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="flex items-center gap-2 text-white bg-amber-600 hover:bg-amber-700 font-medium rounded-lg text-sm px-4 py-2.5">
                        Beli Sekarang
                    </button>
                </form>
            @endif

            <button type="button" @click="showMessageForm = !showMessageForm"
                    class="flex items-center gap-2 text-indigo-600 bg-white hover:bg-indigo-50 border border-indigo-300 font-medium rounded-lg text-sm px-4 py-2.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                Hubungi Penjual
            </button>
        </div>

        <div x-show="showMessageForm" x-cloak class="mt-4">
            <form action="{{ route('messages.store', $vehicle) }}" method="POST" class="flex gap-3">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $vehicle->user_id }}">
                <textarea name="body" rows="2" required
                          class="flex-1 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-2.5"
                          placeholder="Tulis pesan ke {{ $vehicle->seller->name }}...">Halo, saya tertarik dengan {{ $vehicle->title }}. Apakah masih tersedia?</textarea>
                <button type="submit"
                        class="text-white bg-indigo-600 hover:bg-indigo-700 font-medium rounded-lg text-sm px-4 self-end py-2.5">
                    Kirim
                </button>
            </form>
        </div>
    </div>
@endif
        </div>
    </div>
</x-seller-layout>

<script>
    function confirmDeleteVehicle(id) {
        confirmAction({
            title: 'Hapus iklan ini?',
            text: 'Iklan dan semua fotonya akan dihapus permanen.',
        }).then((confirmed) => {
            if (confirmed) {
                document.getElementById('delete-vehicle-' + id).submit();
            }
        });
    }
</script>