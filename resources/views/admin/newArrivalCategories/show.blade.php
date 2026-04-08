<x-app-layout>
    <div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-3xl mx-auto dark:text-white mb-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm">
        <h1 class="text-2xl font-bold mb-6">New Arrival Category Details</h1>

        <div class="space-y-4">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Category</p>
                <p class="text-lg font-medium">{{ $newArrivalCategory->category?->name ?? '-' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Slug</p>
                <p class="text-lg font-medium">{{ $newArrivalCategory->category?->slug ?? '-' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Image</p>
                <img src="{{ asset('storage/' . $newArrivalCategory->image) }}" alt="{{ $newArrivalCategory->category?->name }}" class="max-w-xs rounded-lg border border-gray-200 dark:border-gray-700">
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('new_arrival_categories.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg">Back</a>
        </div>
    </div>
</x-app-layout>
