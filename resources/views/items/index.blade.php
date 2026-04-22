<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Master Item') }}
            </h2>
            <a href="{{ route('items.create') }}" class="inline-flex items-center px-4 py-2 btn-primary border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest">
                {{ __('Tambah') }}
            </a>
        </div>
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
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kategori</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Harga</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Stok</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $item)
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm">{{ $item->id }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm">{{ $item->name }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm">{{ $item->category?->name ?? 'Tanpa kategori' }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-right">{{ $item->stock }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-right space-x-2">
                                        <a href="{{ route('items.edit', $item) }}" class="hover:underline">Edit</a>
                                        <form action="{{ route('items.destroy', $item) }}" method="post" class="inline" onsubmit="return confirm('Hapus item ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-sm app-text-muted">Belum ada item.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $items->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
