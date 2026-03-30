<x-app-layout>
    <div class="max-w-xl mx-auto py-8">
        <h1 class="text-xl font-bold mb-4">Sub Category Details</h1>

        <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
            <p><strong>Name:</strong> {{ $subCategory->name }}</p>
            <p><strong>Created:</strong> {{ $subCategory->created_at->diffForHumans() }}</p>
        </div>

        <div class="mt-4">
            <a href="{{ route('subCategories.edit', $subCategory) }}" class="text-blue-500 hover:underline">Edit</a>
        </div>
    </div>
</x-app-layout>
