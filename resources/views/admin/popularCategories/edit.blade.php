<x-app-layout>
    <div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-3xl mx-auto dark:text-white mb-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm">
        <h1 class="text-2xl font-bold mb-6">Add Popular Category</h1>

        <form action="{{ route('popular_categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-violet-400 dark:bg-gray-700 dark:border-gray-600">
                @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Department</label>
                    <select name="department_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600">
                        <option value="">-- Select Department --</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id')==$department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Category</label>
                    <select name="category_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600">
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id')==$category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">SubCategory</label>
                    <select name="sub_category_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600">
                        <option value="">-- Select SubCategory --</option>
                        @foreach($subCategories as $sub)
                            <option value="{{ $sub->id }}" {{ old('sub_category_id')==$sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Desktop Image</label>
                    <input type="file" name="desktop_image" class="w-full">
                    @error('desktop_image') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 font-medium mb-1">Mobile Image</label>
                    <input type="file" name="mobile_image" class="w-full">
                    @error('mobile_image') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white rounded-lg shadow">Save</button>
                <a href="{{ route('popular_categories.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg ml-2">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
