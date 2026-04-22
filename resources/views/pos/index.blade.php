<x-app-layout>
        <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Point of Sale') }}
            </h2>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="rounded-md bg-green-50 dark:bg-green-900/30 p-4 text-green-800 dark:text-green-200 text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="rounded-md bg-red-50 dark:bg-red-900/30 p-4 text-red-800 dark:text-red-200 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Produk') }}</h3>
                    </div>
                    <div class="p-6 max-h-[32rem] overflow-y-auto">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @forelse ($items as $product)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 flex flex-col">
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $product->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $product->category->name }}</p>
                                        <p class="mt-2 text-sm text-indigo-600 dark:text-indigo-400">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Stok') }}: {{ $product->stock }}</p>
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
                                <p class="text-sm text-gray-500 dark:text-gray-400 col-span-full">{{ __('Tidak ada produk dengan stok.') }}</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Keranjang') }}</h3>
                    </div>
                    <div class="p-6 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-2 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('Produk') }}</th>
                                    <th class="px-2 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('Harga') }}</th>
                                    <th class="px-2 py-2 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('Qty') }}</th>
                                    <th class="px-2 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('Subtotal') }}</th>
                                    <th class="px-2 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('Aksi') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($cartLines as $line)
                                    <tr>
                                        <td class="px-2 py-3 text-sm text-gray-900 dark:text-gray-100">{{ $line->item->name }}</td>
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
                                                <button type="submit" class="text-red-600 dark:text-red-400 text-xs hover:underline">{{ __('Hapus') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-2 py-6 text-center text-sm text-gray-500 dark:text-gray-400">{{ __('Keranjang kosong.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if ($cartLines->isNotEmpty())
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="px-2 py-3 text-right text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        {{ __('Total') }}
                                    </td>
                                    <td class="px-2 py-3 text-right text-sm font-bold text-indigo-600 dark:text-indigo-400">
                                        Rp {{ number_format($cartTotal, 0, ',', '.') }}
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="px-2 py-3 text-right">
                                        <a href="{{ route('pos.checkout') }}"
                                        class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-500">
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
