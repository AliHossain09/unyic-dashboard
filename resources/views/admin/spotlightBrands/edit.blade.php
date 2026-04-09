<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Edit Spotlight Brand</h1>

        <form action="{{ route('spotlight_brands.update', $spotlightBrand) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="brand" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Brand</label>
                <input list="brand-options" name="brand" id="brand" value="{{ old('brand', $spotlightBrand->brand) }}" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600" placeholder="Select or type a brand">
                <datalist id="brand-options">
                    @foreach($brands as $brand)
                        <option value="{{ $brand }}"></option>
                    @endforeach
                </datalist>
                @error('brand') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="serial" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Serial</label>
                <input type="number" min="1" name="serial" id="serial" value="{{ old('serial', $spotlightBrand->serial) }}" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600">
                @error('serial') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Image</label>
                <img src="{{ asset('storage/' . $spotlightBrand->image) }}" alt="{{ $spotlightBrand->brand }}" class="h-24 w-24 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Replace Image</label>
                <input type="file" name="image" id="image" accept=".jpg,.jpeg,.png,.webp" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600">
                @error('image') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $spotlightBrand->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300">Active</label>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('spotlight_brands.index') }}" class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600">Cancel</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-violet-600 text-white hover:bg-violet-700">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>
