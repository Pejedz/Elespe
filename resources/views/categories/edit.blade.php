<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Kategori') }}
        </h2>
    </x-slot>

    <div class="page-wrap">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="panel">
                <div class="panel-body">
                    <form method="post" action="{{ route('categories.update', $category) }}" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <x-input-label for="name" :value="__('Nama')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $category->name)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                        <div class="flex items-center gap-2">
                            <x-primary-button>{{ __('Perbarui') }}</x-primary-button>
                            <a href="{{ route('categories.index') }}" class="text-sm app-text-muted hover:underline">{{ __('Batal') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
