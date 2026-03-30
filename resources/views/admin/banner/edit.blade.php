{{--
<x-app-layout>
    <div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-6xl mx-auto dark:text-white mb-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Edit Banner</h1>

         <form action="{{ route('banners.update', $banner) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block font-medium">Banner Title</label>
                <input type="text" name="title" id="name" value="{{ old('name', $banner->title) }}" class="form-input w-full">
                @error('title')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="name" class="block font-medium">Sub Category</label>
                <input type="text" name="sub_category" id="sub_category" value="{{ old('name', $sub_category->description) }}" class="form-input w-full">
                @error('sub_category')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="name" class="block font-medium">Banner Image</label>
                <input type="file" name="banner_desktop_image" id="name" value="{{ old('name', $banner->banner_image) }}" class="form-input w-full">

            </div>

            <div class="mb-4">
                <label for="name" class="block font-medium">Banner Image</label>
                <input type="file" name="banner_mobile_image" id="name" value="{{ old('name', $banner->banner_image) }}" class="form-input w-full">

            </div>

            <button type="submit"
                    class="btn bg-blue-600 text-white hover:bg-blue-700">Update</button>
        </form>
    </div>
</x-app-layout> --}}


<x-app-layout>
    <div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-6xl mx-auto dark:text-white mb-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Edit Banner</h1>

        <form action="{{ route('banners.update', $banner->id) }}" method="POST" class="space-y-4 p-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Banner Title -->
            <div>
                <label class="block font-medium">Banner Title</label>
                <input type="text" name="title" class="border rounded w-full p-2" value="{{ old('title', $banner->title) }}" required>
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
                        <option value="{{ $subCategory->id }}" {{ $subCategory->id == old('sub_category_id', $banner->sub_category_id) ? 'selected' : '' }}>
                            {{ $subCategory->name }}
                        </option>
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
                @if($banner->banner_desktop_image)
                    <img src="{{ asset('storage/' . $banner->banner_desktop_image) }}" alt="Desktop Image" class="mt-2 w-40 h-auto">
                @endif
                @error('banner_desktop_image')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Mobile -->
            <div>
                <label class="block font-medium">Banner Mobile Image</label>
                <input type="file" name="banner_mobile_image" class="border rounded w-full p-2">
                @if($banner->banner_mobile_image)
                    <img src="{{ asset('storage/' . $banner->banner_mobile_image) }}" alt="Mobile Image" class="mt-2 w-40 h-auto">
                @endif
                @error('banner_mobile_image')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            {{-- ...........................images......................... --}}

            <!-- Submit -->
            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Update Banner
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

