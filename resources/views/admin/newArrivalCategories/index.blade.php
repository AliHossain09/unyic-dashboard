<x-app-layout>
    <div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-7xl mx-auto dark:text-white mb-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">New Arrival Categories</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage categories shown in the New Arrivals section.</p>
            </div>

            <a href="{{ route('new_arrival_categories.create') }}" class="px-4 py-2 rounded-lg bg-violet-600 text-white hover:bg-violet-700">
                + Add New Arrival Category
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form method="GET" action="{{ route('new_arrival_categories.index') }}" class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <input
                name="search"
                value="{{ request('search') }}"
                type="text"
                placeholder="Search category"
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
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Category</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Slug</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Image</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600 dark:text-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($newArrivalCategories as $item)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ $item->category?->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ $item->category?->slug ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->category?->name }}" class="h-14 w-14 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('new_arrival_categories.show', $item) }}" class="px-3 py-1 bg-slate-500 text-white rounded hover:bg-slate-600">View</a>
                                    <a href="{{ route('new_arrival_categories.edit', $item) }}" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</a>
                                    <form action="{{ route('new_arrival_categories.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-500">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-300">
                                No new arrival categories found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $newArrivalCategories->links() }}
        </div>
    </div>
</x-app-layout>
