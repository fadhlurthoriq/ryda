<x-seller-layout title="Detail Transaksi">

    <div class="bg-white shadow-md rounded-lg p-6 max-w-2xl mx-auto">

        <!-- Header struk -->
        <div class="flex items-center justify-between pb-5 border-b">
            <div>
                <h1 class="text-lg font-bold text-gray-900">{{ $transaction->invoice_number }}</h1>
                <p class="text-sm text-gray-500 mt-0.5">{{ $transaction->created_at->translatedFormat('d F Y, H:i') }}</p>
            </div>
            <span class="text-xs px-3 py-1.5 rounded-full font-medium
                @class([
                    'bg-yellow-100 text-yellow-700' => $transaction->status === 'pending',
                    'bg-green-100 text-green-700' => $transaction->status === 'selesai',
                    'bg-gray-100 text-gray-500' => $transaction->status === 'dibatalkan',
                ])">
                {{ ucfirst($transaction->status) }}
            </span>
        </div>

        <!-- Info kendaraan -->
        <div class="flex items-center gap-4 py-5 border-b">
            <img src="{{ $transaction->vehicle->images->first() ? asset('storage/' . $transaction->vehicle->images->first()->path) : 'https://placehold.co/80x80?text=No+Img' }}"
                 class="w-20 h-20 rounded-lg object-cover flex-shrink-0" alt="{{ $transaction->vehicle->title }}">
            <div>
                <p class="font-semibold text-gray-900">{{ $transaction->vehicle->title }}</p>
                <p class="text-sm text-gray-500">{{ $transaction->vehicle->brand }} {{ $transaction->vehicle->model }} &middot; {{ $transaction->vehicle->year }}</p>
            </div>
        </div>

        <!-- Pihak terkait -->
        <div class="grid grid-cols-2 gap-4 py-5 border-b">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">Pembeli</p>
                <p class="text-sm text-gray-800 mt-1">{{ $transaction->buyer->name }}</p>
                <p class="text-xs text-gray-500">{{ $transaction->buyer->phone }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">Penjual</p>
                <p class="text-sm text-gray-800 mt-1">{{ $transaction->seller->name }}</p>
                <p class="text-xs text-gray-500">{{ $transaction->seller->phone }}</p>
            </div>
        </div>

        <!-- Total harga -->
        <div class="flex items-center justify-between py-5 border-b">
            <p class="text-sm font-semibold text-gray-900">Total Harga</p>
            <p class="text-xl font-bold text-amber-600">Rp {{ number_format($transaction->price, 0, ',', '.') }}</p>
        </div>

        <!-- Aksi -->
        <div class="flex items-center justify-between pt-5">
            <a href="{{ route('transactions.index') }}"
               class="flex items-center gap-2 text-gray-700 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg text-sm px-4 py-2.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>

            @if ($transaction->status === 'pending')
                <div class="flex items-center gap-3">
                    <form id="cancel-transaction-{{ $transaction->id }}" action="{{ route('transactions.cancel', $transaction) }}" method="POST">
                        @csrf
                        @method('PATCH')
                    </form>
                    <button type="button"
                            onclick="confirmCancelTransaction({{ $transaction->id }})"
                            class="text-red-600 bg-white hover:bg-red-50 border border-red-300 font-medium rounded-lg text-sm px-4 py-2.5">
                        Batalkan
                    </button>

                    @if (auth()->id() === $transaction->seller_id)
                        <form id="confirm-transaction-{{ $transaction->id }}" action="{{ route('transactions.confirm', $transaction) }}" method="POST">
                            @csrf
                            @method('PATCH')
                        </form>
                        <button type="button"
                                onclick="confirmConfirmTransaction({{ $transaction->id }})"
                                class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-4 py-2.5">
                            Konfirmasi
                        </button>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-seller-layout>

<script>
    function confirmCancelTransaction(id) {
        confirmAction({
            title: 'Batalkan transaksi ini?',
            text: 'Transaksi akan ditandai sebagai dibatalkan dan tidak bisa diproses lagi.',
        }).then((confirmed) => {
            if (confirmed) {
                document.getElementById('cancel-transaction-' + id).submit();
            }
        });
    }

    function confirmConfirmTransaction(id) {
        confirmAction({
            title: 'Konfirmasi transaksi ini?',
            text: 'Kendaraan akan otomatis ditandai sebagai terjual, dan transaksi pending lain untuk kendaraan ini akan dibatalkan.',
            icon: 'question',
            confirmButtonText: 'Ya, konfirmasi',
        }).then((confirmed) => {
            if (confirmed) {
                document.getElementById('confirm-transaction-' + id).submit();
            }
        });
    }
</script>