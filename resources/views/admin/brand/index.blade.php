<x-app-layout>
    <div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-6xl mx-auto dark:text-white mb-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Brands</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage product brands and slugs.</p>
            </div>
            <a href="{{ route('brands.create') }}" class="px-4 py-2 rounded-lg bg-violet-600 text-white hover:bg-violet-700">Add Brand</a>
        </div>

        <div class="overflow-x-auto bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Slug</th>
                        <th class="px-4 py-3">Created</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($brands as $brand)
                        <tr>
                            <td class="px-4 py-3">{{ $brand->id }}</td>
                            <td class="px-4 py-3">{{ $brand->name }}</td>
                            <td class="px-4 py-3">{{ $brand->slug }}</td>
                            <td class="px-4 py-3">{{ $brand->created_at->format('Y-m-d') }}</td>
                            <td class="px-4 py-3 space-x-2">
                                <a href="{{ route('brands.show', $brand) }}" class="px-3 py-1 rounded bg-slate-500 text-white">View</a>
                                <a href="{{ route('brands.edit', $brand) }}" class="px-3 py-1 rounded bg-yellow-500 text-white">Edit</a>
                                <form action="{{ route('brands.destroy', $brand) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this brand?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 rounded bg-red-600 text-white">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">No brands found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $brands->links() }}
        </div>
    </div>
</x-app-layout>
