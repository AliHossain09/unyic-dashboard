<x-app-layout>
    <div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-7xl mx-auto dark:text-white mb-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Brands In the Spotlight</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage the 2 active brands shown in the spotlight section.</p>
            </div>

            <a href="{{ route('spotlight_brands.create') }}" class="px-4 py-2 rounded-lg bg-violet-600 text-white hover:bg-violet-700">
                + Add Spotlight Brand
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="GET" action="{{ route('spotlight_brands.index') }}" class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <input
                name="search"
                value="{{ request('search') }}"
                type="text"
                placeholder="Search brand"
                class="w-full max-w-xs px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
            >

            <select
                name="perPage"
                onchange="this.form.submit()"
                class="rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 px-3 py-2"
            >
                @php $pp = request('perPage', 10); @endphp
                <option value="10" {{ $pp == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ $pp == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ $pp == 50 ? 'selected' : '' }}>50</option>
            </select>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">#</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Brand</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Slug</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Serial</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Image</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600 dark:text-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($spotlightBrands as $item)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ $spotlightBrands->firstItem() + $loop->index }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ $item->brand }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ $item->slug }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ $item->serial }}</td>
                            <td class="px-4 py-3 text-sm">
                                <form action="{{ route('spotlight_brands.toggle-status', $item) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        type="submit"
                                        class="px-3 py-1 rounded text-white {{ $item->is_active ? 'bg-green-600 hover:bg-green-700' : 'bg-slate-500 hover:bg-slate-600' }}"
                                    >
                                        {{ $item->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-4 py-3">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->brand }}" class="h-14 w-14 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('spotlight_brands.show', $item) }}" class="px-3 py-1 bg-slate-500 text-white rounded hover:bg-slate-600">View</a>
                                    <a href="{{ route('spotlight_brands.edit', $item) }}" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</a>
                                    <form action="{{ route('spotlight_brands.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-500">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-300">
                                No spotlight brands found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $spotlightBrands->links() }}
        </div>
    </div>
</x-app-layout>
