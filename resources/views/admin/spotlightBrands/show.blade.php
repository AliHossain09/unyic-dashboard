<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Spotlight Brand Details</h1>

        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 space-y-5">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Brand</p>
                <p class="text-lg font-medium">{{ $spotlightBrand->brand }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Slug</p>
                <p class="text-lg font-medium">{{ $spotlightBrand->slug }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Serial</p>
                <p class="text-lg font-medium">{{ $spotlightBrand->serial }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                <p class="text-lg font-medium">{{ $spotlightBrand->is_active ? 'Active' : 'Inactive' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Image</p>
                <img src="{{ asset('storage/' . $spotlightBrand->image) }}" alt="{{ $spotlightBrand->brand }}" class="max-w-xs rounded-lg border border-gray-200 dark:border-gray-700">
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('spotlight_brands.edit', $spotlightBrand) }}" class="px-4 py-2 rounded-lg bg-yellow-500 text-white hover:bg-yellow-600">Edit</a>
                <a href="{{ route('spotlight_brands.index') }}" class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600">Back</a>
            </div>
        </div>
    </div>
</x-app-layout>
