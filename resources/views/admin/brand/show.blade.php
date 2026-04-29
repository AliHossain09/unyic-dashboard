<x-app-layout>
    <div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-4xl mx-auto dark:text-white mb-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Brand Details</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">View brand metadata.</p>
            </div>
            <a href="{{ route('brands.index') }}" class="px-4 py-2 rounded-lg bg-slate-600 text-white hover:bg-slate-700">Back to Brands</a>
        </div>

        <div class="grid grid-cols-1 gap-4">
            <div class="bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
                <p class="text-sm text-gray-500">Name</p>
                <p class="mt-2 text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $brand->name }}</p>
            </div>

            <div class="bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
                <p class="text-sm text-gray-500">Slug</p>
                <p class="mt-2 text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $brand->slug }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
