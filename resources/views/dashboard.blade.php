<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="page-wrap">
        <div class="page-container">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="panel panel-body">
                    <p class="text-sm font-medium app-text-muted">{{ __('Total Kategori') }}</p>
                    <p class="mt-2 text-3xl font-bold">{{ $totalCategories }}</p>
                </div>
                <div class="panel panel-body">
                    <p class="text-sm font-medium app-text-muted">{{ __('Total Item') }}</p>
                    <p class="mt-2 text-3xl font-bold">{{ $totalItems }}</p>
                </div>
                <div class="panel panel-body">
                    <p class="text-sm font-medium app-text-muted">{{ __('Total Transaksi') }}</p>
                    <p class="mt-2 text-3xl font-bold">{{ $totalTransactions }}</p>
                </div>
            </div>
            <div class="mt-8">
                <a href="{{ route('pos.index') }}" class="inline-flex items-center px-4 py-2 btn-primary border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest">
                    {{ __('Buka Keranjang') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
