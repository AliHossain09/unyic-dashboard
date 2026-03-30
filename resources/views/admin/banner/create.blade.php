
 {{-- <x-app-layout>
    <div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-6xl mx-auto dark:text-white mb-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Add Banner</h1>
        <form action="{{ route('collections.store') }}" method="POST" class="space-y-4 p-6" enctype="multipart/form-data">
            @csrf --}}

            <!-- Banners Title -->
            {{-- <div>
                <label class="block font-medium">Banner Title</label>
                <input type="text" name="title" class="border rounded w-full p-2">
            </div> --}}

            <!-- Price -->
            {{-- <div>
                <label class="block font-medium">Sub Category</label>
                <input type="text" step="0.01" name="description" class="border rounded w-full p-2">
            </div> --}}

            {{-- ...........................images......................... --}}
            <!-- desktop -->
            {{-- <div>
                <label class="block font-medium">Banner Desktop Image</label>
                <input type="file" step="0.01" name="banner_desktop_image" class="border rounded w-full p-2">
            </div> --}}

            <!-- mobile -->
            {{-- <div>
                <label class="block font-medium">Banner Mobile Image</label>
                <input type="file" step="0.01" name="banner_mobile_image" class="border rounded w-full p-2">
            </div> --}}
            {{-- ...........................images......................... --}}

             <!-- Submit -->
            {{-- <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Save Collection
                </button>
            </div>
        </form>
    </div>

</x-app-layout> --}}



<x-app-layout>
    <div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-6xl mx-auto dark:text-white mb-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Add Banner</h1>

        <form action="{{ route('banners.store') }}" method="POST" class="space-y-4 p-6" enctype="multipart/form-data">
            @csrf

            <!-- Banner Title -->
            <div>
                <label class="block font-medium">Banner Title</label>
                <input type="text" name="title" class="border rounded w-full p-2" required>
                @error('title')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sub Category -->
            <div>
                <label class="block font-medium">Sub Category</label>
                <select name="sub_category_id" class="border rounded w-full p-2" required>
                    <option value="">-- Select Sub Category --</option>
                    @foreach ($subCategories as $subCategory)
                        <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                    @endforeach
                </select>
                @error('sub_category_id')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- ...........................images......................... --}}
            <!-- Desktop -->
            <div>
                <label class="block font-medium">Banner Desktop Image</label>
                <input type="file" name="banner_desktop_image" class="border rounded w-full p-2">
                @error('banner_desktop_image')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Mobile -->
            <div>
                <label class="block font-medium">Banner Mobile Image</label>
                <input type="file" name="banner_mobile_image" class="border rounded w-full p-2">
                @error('banner_mobile_image')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            {{-- ...........................images......................... --}}

            <!-- Submit -->
            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Save Banner
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

