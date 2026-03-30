<x-app-layout>
    <div class="max-w-xl mx-auto py-8">
        <h1 class="text-xl font-bold mb-4">Category Details</h1>

        <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
            <p><strong>Name:</strong> {{ $category->name }}</p>
            <p><strong>Created:</strong> {{ $category->created_at->diffForHumans() }}</p>
        </div>

        <div class="mt-4">
            <a href="{{ route('categories.edit', $category) }}" class="text-blue-500 hover:underline">Edit</a>
        </div>
    </div>
</x-app-layout>
