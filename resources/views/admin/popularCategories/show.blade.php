<x-app-layout>
    <div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-3xl mx-auto dark:text-white mb-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm">
        <h1 class="text-2xl font-bold mb-6">Popular Category Details</h1>

        <div class="space-y-4">
            <p><strong>Title:</strong> {{ $popularCategory->title }}</p>
            <p><strong>Department:</strong> {{ $popularCategory->department?->name ?? '-' }}</p>
            <p><strong>Category:</strong> {{ $popularCategory->category?->name ?? '-' }}</p>
            <p><strong>SubCategory:</strong> {{ $popularCategory->subCategory?->name ?? '-' }}</p>
            <div class="flex gap-4">
                @if($popularCategory->desktop_image)
                    <div>
                        <p class="font-medium">Desktop Image:</p>
                        <img src="{{ asset('storage/'.$popularCategory->desktop_image) }}" class="w-48 h-auto rounded">
                    </div>
                @endif
                @if($popularCategory->mobile_image)
                    <div>
                        <p class="font-medium">Mobile Image:</p>
                        <img src="{{ asset('storage/'.$popularCategory->mobile_image) }}" class="w-32 h-auto rounded">
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('popular_categories.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg">Back</a>
        </div>
    </div>
</x-app-layout>
