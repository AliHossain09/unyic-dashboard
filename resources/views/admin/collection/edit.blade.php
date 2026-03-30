
<x-app-layout>
    <div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-6xl mx-auto dark:text-white mb-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Edit Collection</h1>

         <form action="{{ route('collections.update', $collection) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block font-medium">Name</label>
                <input type="text" name="title" id="name" value="{{ old('name', $collection->title) }}" class="form-input w-full">
                @error('title')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="name" class="block font-medium">Description</label>
                <input type="text" name="name" id="description" value="{{ old('name', $collection->description) }}" class="form-input w-full">
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="name" class="block font-medium">Banner Image</label>
                <input type="file" name="banner_image" id="name" value="{{ old('name', $collection->banner_image) }}" class="form-input w-full">

            </div>

            <button type="submit"
                    class="btn bg-blue-600 text-white hover:bg-blue-700">Update</button>
        </form>
    </div>
</x-app-layout>
