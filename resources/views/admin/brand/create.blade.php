<x-app-layout>
    <div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-4xl mx-auto dark:text-white mb-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Add Brand</h1>

        <form action="{{ route('brands.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block font-medium mb-2">Brand Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="border rounded w-full p-3" placeholder="Enter brand name">
                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <button type="submit" class="bg-violet-600 text-white px-6 py-2 rounded">Save Brand</button>
                <a href="{{ route('brands.index') }}" class="ml-3 text-sm text-gray-600 hover:text-gray-900">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
