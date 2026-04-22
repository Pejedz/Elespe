<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="page-wrap">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="panel">
                <div class="panel-header">
                    <h3 class="text-lg font-medium">{{ __('Ringkasan') }}</h3>
                </div>
                <div class="panel-body overflow-x-auto">
                    <table class="min-w-full data-table">
                        <thead>
                            <tr>
                                <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('Produk') }}</th>
                                <th class="px-2 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('Harga') }}</th>
                                <th class="px-2 py-2 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('Qty') }}</th>
                                <th class="px-2 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('Subtotal') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartLines as $line)
                                <tr>
                                    <td class="px-2 py-3 text-sm">{{ $line->item->name }}</td>
                                    <td class="px-2 py-3 text-sm text-right">Rp {{ number_format($line->item->price, 0, ',', '.') }}</td>
                                    <td class="px-2 py-3 text-sm text-center">{{ $line->qty }}</td>
                                    <td class="px-2 py-3 text-sm text-right">Rp {{ number_format($line->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="px-2 py-3 text-right text-sm font-semibold">{{ __('Total') }}</td>
                                <td class="px-2 py-3 text-right text-sm font-bold">Rp {{ number_format($cartTotal, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="panel">
                <div class="panel-body">
                    <form method="post" action="{{ route('pos.checkout.store') }}" class="space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="pay_total" :value="__('Pembayaran (pay_total)')" />
                            <x-text-input id="pay_total" name="pay_total" type="number" min="{{ $cartTotal }}" step="1" class="mt-1 block w-full" :value="old('pay_total', $cartTotal)" required />
                            <p class="mt-1 text-xs app-text-muted">{{ __('Minimal sama dengan total: Rp') }} {{ number_format($cartTotal, 0, ',', '.') }}</p>
                            <x-input-error class="mt-2" :messages="$errors->get('pay_total')" />
                        </div>
                        <div class="flex items-center gap-2">
                            <x-primary-button>{{ __('Simpan Transaksi') }}</x-primary-button>
                            <a href="{{ route('pos.index') }}" class="text-sm app-text-muted hover:underline">{{ __('Kembali ke POS') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
