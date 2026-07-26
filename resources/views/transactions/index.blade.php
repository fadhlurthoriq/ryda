<x-seller-layout title="Transaksi">

    <div class="bg-white shadow-md rounded-lg overflow-hidden">

        <!-- Search -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 p-4 border-b">
            <form method="GET" action="{{ route('transactions.index') }}" class="w-full md:w-1/2 flex gap-3">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5"
                        placeholder="Cari invoice atau judul iklan...">
                </div>

                <select name="status" onchange="this.form.submit()"
                        class="appearance-none border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 pl-3 pr-10 py-2.5 bg-no-repeat bg-[right_0.75rem_center]"
                        style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20fill%3D%22none%22%20viewBox%3D%220%200%2020%2020%22%3E%3Cpath%20stroke%3D%22%236B7280%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20stroke-width%3D%221.5%22%20d%3D%22M6%208l4%204%204-4%22%2F%3E%3C%2Fsvg%3E');">
                    <option value="">Semua</option>
                    <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                    <option value="selesai" @selected(request('status') === 'selesai')>Selesai</option>
                    <option value="dibatalkan" @selected(request('status') === 'dibatalkan')>Dibatalkan</option>
                </select>
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3">Invoice</th>
                        <th scope="col" class="px-4 py-3">Kendaraan</th>
                        <th scope="col" class="px-4 py-3">Pembeli</th>
                        <th scope="col" class="px-4 py-3">Harga</th>
                        <th scope="col" class="px-4 py-3">Status</th>
                        <th scope="col" class="px-4 py-3"><span class="sr-only">Aksi</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                        <tr class="border-b hover:bg-gray-50">
                            <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">
                                {{ $transaction->invoice_number }}
                            </th>
                            <td class="px-4 py-3">{{ $transaction->vehicle->title }}</td>
                            <td class="px-4 py-3">{{ $transaction->buyer->name }}</td>
                            <td class="px-4 py-3">Rp {{ number_format($transaction->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                <span class="text-xs px-2 py-1 rounded-full
                                    @class([
                                        'bg-yellow-100 text-yellow-700' => $transaction->status === 'pending',
                                        'bg-green-100 text-green-700' => $transaction->status === 'selesai',
                                        'bg-gray-100 text-gray-500' => $transaction->status === 'dibatalkan',
                                    ])">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 flex items-center justify-end">
                                <a href="{{ route('transactions.show', $transaction) }}"
                                   class="inline-flex items-center p-1.5 text-gray-500 hover:text-gray-800 rounded-lg hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                                Belum ada transaksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($transactions->hasPages())
            <div class="p-4 border-t">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</x-seller-layout>