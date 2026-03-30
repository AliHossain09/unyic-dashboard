<x-app-layout>
    <div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-6xl mx-auto dark:text-white mb-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Add Category</h1>

        <form method="POST" action="{{ route('categories.store') }}">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category Name</label>
                <input type="text" name="name" id="name" required
                       class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white" />
            </div>

            <div class="mb-4">
    <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Department</label>
    <select name="department_id" id="department_id" required
            class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
        @foreach($departments as $department)
            <option value="{{ $department->id }}">{{ $department->name }}</option>
        @endforeach
    </select>
</div>

            <button type="submit"
                    class="btn bg-blue-600 text-white hover:bg-blue-700">Save</button>
        </form>
    </div>
</x-app-layout>

