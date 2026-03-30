
 <x-app-layout>
    <div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-6xl mx-auto dark:text-white mb-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Add Collection</h1>
        <form action="{{ route('collections.store') }}" method="POST" class="space-y-4 p-6" enctype="multipart/form-data">
            @csrf

            <!-- Collection Name -->
            <div>
                <label class="block font-medium">Collection Name</label>
                <input type="text" name="title" class="border rounded w-full p-2">
            </div>

            <!-- Price -->
            <div>
                <label class="block font-medium">Description</label>
                <input type="text" step="0.01" name="description" class="border rounded w-full p-2">
            </div>

            <!-- Old Price -->
            <div>
                <label class="block font-medium">Banner Image</label>
                <input type="file" step="0.01" name="banner_image" class="border rounded w-full p-2">
            </div>


            <!-- Submit -->
            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Save Collection
                </button>
            </div>
        </form>
    </div>

</x-app-layout>
