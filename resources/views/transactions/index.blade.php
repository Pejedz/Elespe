<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Histori Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-50 dark:bg-green-900/30 p-4 text-green-800 dark:text-green-200 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ID</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Tanggal') }}</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Kasir') }}</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Total') }}</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Bayar') }}</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($transactions as $tx)
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm">{{ $tx->id }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm">{{ $tx->date->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm">{{ $tx->user->name }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-right">Rp {{ number_format($tx->total, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-right">Rp {{ number_format($tx->pay_total, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-right">
                                        <a href="{{ route('transactions.show', $tx) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('Detail') }}</a>
                                        <span class="mx-1 text-gray-300 dark:text-gray-600">|</span>
                                        <a href="{{ route('transactions.print', $tx) }}" target="_blank" class="text-green-600 dark:text-green-400 hover:underline">{{ __('Print') }}</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">{{ __('Belum ada transaksi.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $transactions->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
