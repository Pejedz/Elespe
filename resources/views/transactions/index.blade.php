<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Histori Transaksi') }}
        </h2>
    </x-slot>

    <div class="page-wrap">
        <div class="page-container">
            @if (session('success'))
                <div class="mb-4 text-sm alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="panel">
                <div class="panel-body overflow-x-auto">
                    <table class="min-w-full data-table">
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
                        <tbody>
                            @forelse ($transactions as $tx)
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm">{{ $tx->id }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm">{{ $tx->date->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm">{{ $tx->user->name }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-right">Rp {{ number_format($tx->total, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-right">Rp {{ number_format($tx->pay_total, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-right">
                                        <a href="{{ route('transactions.show', $tx) }}" class="hover:underline">{{ __('Detail') }}</a>
                                        <span class="mx-1 app-text-muted">|</span>
                                        <a href="{{ route('transactions.print', $tx) }}" target="_blank" class="text-emerald-500 hover:underline">{{ __('Print') }}</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-sm app-text-muted">{{ __('Belum ada transaksi.') }}</td>
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
