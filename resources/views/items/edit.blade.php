<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Item') }}
        </h2>
    </x-slot>

    <div class="page-wrap">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="panel">
                <div class="panel-body">
                    <form method="post" action="{{ route('items.update', $item) }}" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <x-input-label for="category_id" :value="__('Kategori')" />
                            <select id="category_id" name="category_id" class="mt-1 block w-full border app-border app-surface focus:border-transparent focus:ring-2 focus-ring rounded-lg shadow-sm">
                                <option value="">{{ __('Tanpa kategori') }}</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" @selected(old('category_id', $item->category_id) == $cat->id)>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                        </div>
                        <div>
                            <x-input-label for="name" :value="__('Nama')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $item->name)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                        <div>
                            <x-input-label for="price" :value="__('Harga')" />
                            <x-text-input id="price" name="price" type="number" min="0" step="1" class="mt-1 block w-full" :value="old('price', $item->price)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('price')" />
                        </div>
                        <div>
                            <x-input-label for="stock" :value="__('Stok')" />
                            <x-text-input id="stock" name="stock" type="number" min="0" step="1" class="mt-1 block w-full" :value="old('stock', $item->stock)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('stock')" />
                        </div>
                        <div class="flex items-center gap-2">
                            <x-primary-button>{{ __('Perbarui') }}</x-primary-button>
                            <a href="{{ route('items.index') }}" class="text-sm app-text-muted hover:underline">{{ __('Batal') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
