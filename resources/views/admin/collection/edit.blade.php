
<x-app-layout>
    <div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-6xl mx-auto dark:text-white mb-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Edit Collection</h1>

         <form action="{{ route('collections.update', $collection) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block font-medium">Name</label>
                <input type="text" name="title" id="name" value="{{ old('title', $collection->title) }}" class="form-input w-full">
                @error('title')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block font-medium">Description</label>
                <input type="text" name="description" id="description" value="{{ old('description', $collection->description) }}" class="form-input w-full">
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="brand" class="block font-medium">Brand</label>
                <input type="text" name="brand" id="brand" value="{{ old('brand', $collection->brand) }}" class="form-input w-full">
                @error('brand')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="short_description" class="block font-medium">Short Description</label>
                <input type="text" name="short_description" id="short_description" value="{{ old('short_description', $collection->short_description) }}" class="form-input w-full">
                @error('short_description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="banner_image" class="block font-medium">Banner Image</label>
                <input type="file" name="banner_image" id="banner_image" class="form-input w-full">
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $collection->is_featured) ? 'checked' : '' }}>
                    <span>Featured Collection</span>
                </label>
            </div>

            <button type="submit"
                    class="btn bg-blue-600 text-white hover:bg-blue-700">Update</button>
        </form>
    </div>
</x-app-layout>
