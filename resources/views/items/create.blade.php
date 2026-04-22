<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Item') }}
        </h2>
    </x-slot>

    <div class="page-wrap">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="panel">
                <div class="panel-body">
                    <form method="post" action="{{ route('items.store') }}" class="space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="category_id" :value="__('Kategori')" />
                            <select id="category_id" name="category_id" class="mt-1 block w-full border app-border app-surface focus:border-transparent focus:ring-2 focus-ring rounded-lg shadow-sm">
                                <option value="">{{ __('Tanpa kategori') }}</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                        </div>
                        <div>
                            <x-input-label for="name" :value="__('Nama')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                        <div>
                            <x-input-label for="price" :value="__('Harga')" />
                            <x-text-input id="price" name="price" type="number" min="0" step="1" class="mt-1 block w-full" :value="old('price')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('price')" />
                        </div>
                        <div>
                            <x-input-label for="stock" :value="__('Stok')" @class(['!text-red-600 dark:!text-red-400' => $errors->has('stock')]) />
                            <x-text-input
                                id="stock"
                                name="stock"
                                type="number"
                                min="1"
                                step="1"
                                :value="old('stock')"
                                required
                                @class([
                                    'mt-1 block w-full',
                                    '!border-red-500 !text-red-900 dark:!text-red-200 !ring-1 !ring-red-500 focus:!border-red-500 focus:!ring-red-500 dark:!border-red-500 dark:focus:!border-red-500 dark:focus:!ring-red-500' => $errors->has('stock'),
                                ])
                            />
                            <x-input-error class="mt-2 font-medium text-red-600 dark:text-red-400" :messages="$errors->get('stock')" />
                        </div>
                        <div class="flex items-center gap-2">
                            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                            <a href="{{ route('items.index') }}" class="text-sm app-text-muted hover:underline">{{ __('Batal') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
