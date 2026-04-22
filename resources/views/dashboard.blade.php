<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Kategori') }}</p>
                    <p class="mt-2 text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ $totalCategories }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Item') }}</p>
                    <p class="mt-2 text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ $totalItems }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Transaksi') }}</p>
                    <p class="mt-2 text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ $totalTransactions }}</p>
                </div>
            </div>
            <div class="mt-8">
                <a href="{{ route('pos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white">
                    {{ __('Buka POS') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
