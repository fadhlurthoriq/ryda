<x-seller-layout title="Dashboard">

    <!-- Ringkasan angka -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-sm text-gray-500">Total Iklan</p>
            <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-sm text-gray-500">Tersedia</p>
            <p class="text-3xl font-bold text-green-600 mt-1">{{ $stats['tersedia'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-sm text-gray-500">Terjual</p>
            <p class="text-3xl font-bold text-gray-400 mt-1">{{ $stats['terjual'] }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Iklan terbaru -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-5 py-4 border-b flex items-center justify-between">
                <h2 class="font-semibold text-gray-800">Iklan Terbaru</h2>
                <a href="{{ route('vehicles.my-vehicles') }}" class="text-sm text-indigo-600 hover:underline">Lihat semua</a>
            </div>
            <div class="divide-y">
                @forelse ($recentVehicles as $vehicle)
                    <a href="{{ route('vehicles.show', $vehicle) }}" class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50">
                        <img src="{{ $vehicle->images->first() ? asset('storage/' . $vehicle->images->first()->path) : 'https://placehold.co/64x64?text=No+Image' }}"
                             class="w-14 h-14 rounded object-cover flex-shrink-0" alt="{{ $vehicle->title }}">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-gray-800 truncate">{{ $vehicle->title }}</p>
                            <p class="text-sm text-gray-500">Rp {{ number_format($vehicle->price, 0, ',', '.') }}</p>
                        </div>
                        <span class="ml-auto text-xs px-2 py-1 rounded-full
                            {{ $vehicle->status === 'tersedia' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ ucfirst($vehicle->status) }}
                        </span>
                    </a>
                @empty
                    <p class="px-5 py-6 text-sm text-gray-400 text-center">Belum ada iklan. <a href="{{ route('vehicles.create') }}" class="text-indigo-600 hover:underline">Buat iklan pertama</a></p>
                @endforelse
            </div>
        </div>

        <!-- Transaksi perlu dikonfirmasi -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-5 py-4 border-b flex items-center justify-between">
                <h2 class="font-semibold text-gray-800">Perlu Dikonfirmasi</h2>
                <a href="{{ route('transactions.index') }}" class="text-sm text-indigo-600 hover:underline">Lihat semua</a>
            </div>
            <div class="divide-y">
                @forelse ($pendingTransactions as $transaction)
                    <div class="px-5 py-3">
                        <div class="flex items-center justify-between">
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-800 truncate">{{ $transaction->vehicle->title }}</p>
                                <p class="text-xs text-gray-500">{{ $transaction->buyer->name }} &middot; {{ $transaction->invoice_number }}</p>
                            </div>
                            <a href="{{ route('transactions.show', $transaction) }}"
                               class="text-xs px-3 py-1.5 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 flex-shrink-0">
                                Tinjau
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="px-5 py-6 text-sm text-gray-400 text-center">Tidak ada transaksi yang perlu dikonfirmasi.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-seller-layout>