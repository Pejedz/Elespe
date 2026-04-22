<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Transaksi #') }}{{ $transaction->id }}
            </h2>
            <div class="flex items-center gap-4">
                <a href="{{ route('transactions.print', $transaction) }}" target="_blank" class="text-sm text-emerald-500 hover:underline">{{ __('Print Struk') }}</a>
                <a href="{{ route('transactions.index') }}" class="text-sm hover:underline">{{ __('Kembali') }}</a>
            </div>
        </div>
    </x-slot>

    <div class="page-wrap">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="panel panel-body">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="app-text-muted">{{ __('Tanggal') }}</dt>
                        <dd class="font-medium">{{ $transaction->date->format('d/m/Y H:i:s') }}</dd>
                    </div>
                    <div>
                        <dt class="app-text-muted">{{ __('Kasir') }}</dt>
                        <dd class="font-medium">{{ $transaction->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="app-text-muted">{{ __('Total') }}</dt>
                        <dd class="font-medium">Rp {{ number_format($transaction->total, 0, ',', '.') }}</dd>
                    </div>
                    <div>
                        <dt class="app-text-muted">{{ __('Pembayaran') }}</dt>
                        <dd class="font-medium">Rp {{ number_format($transaction->pay_total, 0, ',', '.') }}</dd>
                    </div>
                    <div>
                        <dt class="app-text-muted">{{ __('Kembalian') }}</dt>
                        <dd class="font-medium">Rp {{ number_format($transaction->change, 0, ',', '.') }}</dd>
                    </div>
                </dl>
            </div>

            <div class="panel">
                <div class="panel-header">
                    <h3 class="text-lg font-medium">{{ __('Item') }}</h3>
                </div>
                <div class="panel-body overflow-x-auto">
                    <table class="min-w-full data-table">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('Produk') }}</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('Kategori') }}</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('Qty') }}</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('Subtotal') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaction->details as $detail)
                                <tr>
                                    <td class="px-4 py-3 text-sm">{{ $detail->item->name }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $detail->item->category?->name ?? 'Tanpa kategori' }}</td>
                                    <td class="px-4 py-3 text-sm text-center">{{ $detail->qty }}</td>
                                    <td class="px-4 py-3 text-sm text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
