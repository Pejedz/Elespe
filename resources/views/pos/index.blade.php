<x-app-layout>
        <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Point of Sale') }}
            </h2>
        </div>
    </x-slot>
    <div class="page-wrap">
        <div class="page-container space-y-6">
            @if (session('success'))
                <div class="text-sm alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="text-sm alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="panel">
                    <div class="panel-header">
                        <h3 class="text-lg font-medium">{{ __('Produk') }}</h3>
                    </div>
                    <div class="panel-body max-h-[32rem] overflow-y-auto">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @forelse ($items as $product)
                                <div class="app-surface p-4 flex flex-col">
                                    <div class="flex-1">
                                        <p class="font-medium">{{ $product->name }}</p>
                                        <p class="text-xs app-text-muted">{{ $product->category?->name ?? 'Tanpa kategori' }}</p>
                                        <p class="mt-2 text-sm font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                        <p class="text-xs app-text-muted">{{ __('Stok') }}: {{ $product->stock }}</p>
                                        @if ($product->stock <= $lowStockThreshold)
                                            <p class="mt-1 text-xs font-semibold text-amber-600 dark:text-amber-400">
                                                Stok menipis - segera restok
                                            </p>
                                        @endif
                                    </div>
                                    <form action="{{ route('pos.cart.add') }}" method="post" class="mt-3 flex items-end gap-2">
                                        @csrf
                                        <input type="hidden" name="item_id" value="{{ $product->id }}">
                                        <div class="flex-1">
                                            <x-input-label for="qty-{{ $product->id }}" :value="__('Qty')" />
                                            <x-text-input id="qty-{{ $product->id }}" name="qty" type="number" min="1" value="1" class="mt-1 block w-full" required />
                                        </div>
                                        <x-primary-button class="!py-2">{{ __('Add') }}</x-primary-button>
                                    </form>
                                    <x-input-error class="mt-2" :messages="$errors->get('add_qty_'.$product->id)" />
                                    @if ((int) old('item_id') === $product->id)
                                        <x-input-error class="mt-1" :messages="$errors->get('qty')" />
                                        <x-input-error class="mt-1" :messages="$errors->get('item_id')" />
                                    @endif
                                </div>
                            @empty
                                <p class="text-sm app-text-muted col-span-full">{{ __('Tidak ada produk dengan stok.') }}</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-header">
                        <h3 class="text-lg font-medium">{{ __('Keranjang') }}</h3>
                    </div>
                    <div class="panel-body overflow-x-auto">
                        <table class="min-w-full data-table">
                            <thead>
                                <tr>
                                    <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('Produk') }}</th>
                                    <th class="px-2 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('Harga') }}</th>
                                    <th class="px-2 py-2 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('Qty') }}</th>
                                    <th class="px-2 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('Subtotal') }}</th>
                                    <th class="px-2 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('Aksi') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cartLines as $line)
                                    <tr>
                                        <td class="px-2 py-3 text-sm">{{ $line->item->name }}</td>
                                        <td class="px-2 py-3 text-sm text-right">Rp {{ number_format($line->item->price, 0, ',', '.') }}</td>
                                        <td class="px-2 py-3 text-sm">
                                            <form action="{{ route('pos.cart.update', $line->item) }}" method="post" class="flex justify-center">
                                                @csrf
                                                @method('PATCH')
                                                <x-text-input name="qty" type="number" min="0" :value="$line->qty" class="w-20 text-center" required />
                                                <x-primary-button class="ms-2 !py-1 !px-2 text-xs">{{ __('OK') }}</x-primary-button>
                                            </form>
                                            <x-input-error class="mt-1" :messages="$errors->get('update_qty_'.$line->item->id)" />
                                        </td>
                                        <td class="px-2 py-3 text-sm text-right font-medium">Rp {{ number_format($line->subtotal, 0, ',', '.') }}</td>
                                        <td class="px-2 py-3 text-sm text-right">
                                            <form action="{{ route('pos.cart.remove', $line->item) }}" method="post" onsubmit="return confirm('Hapus dari keranjang?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 text-xs hover:underline">{{ __('Hapus') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-2 py-6 text-center text-sm app-text-muted">{{ __('Keranjang kosong.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if ($cartLines->isNotEmpty())
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="px-2 py-3 text-right text-sm font-semibold">
                                        {{ __('Total') }}
                                    </td>
                                    <td class="px-2 py-3 text-right text-sm font-bold">
                                        Rp {{ number_format($cartTotal, 0, ',', '.') }}
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="px-2 py-3 text-right">
                                        <a href="{{ route('pos.checkout') }}"
                                        class="inline-flex items-center px-4 py-2 btn-primary border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest">
                                            {{ __('Checkout') }}
                                        </a>
                                    </td>
                                </tr>
                            </tfoot>
                        @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
