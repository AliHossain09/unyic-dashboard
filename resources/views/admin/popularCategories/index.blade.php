{{-- <x-app-layout>
    <div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-7xl mx-auto dark:text-white mb-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm">
        <!-- Heading -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Popular Categories</h1>
            <a href="{{ route('popular_categories.create') }}"
               class="px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white rounded-lg shadow-sm">+ Add Popular Category</a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Department</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">SubCategory</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($popularCategories as $item)
                    <tr>
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $item->title }}</td>
                        <td class="px-6 py-4">{{ $item->department?->name ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $item->category?->name ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $item->subCategory?->name ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('popular_categories.edit', $item->id) }}" class="px-2 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded">Edit</a>
                                <form action="{{ route('popular_categories.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-2 py-1 bg-red-500 hover:bg-red-600 text-white rounded">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout> --}}


{{-- ///////////////////////////////////////////////////////////////////////////////////////////// --}}

<x-app-layout>
<div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-7xl mx-auto dark:text-white mb-6
            bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm">

  <!-- Heading -->
  <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 text-center
             border-b border-gray-200 dark:border-gray-700 pb-2">
      Popular Categories
  </h1>

  <!-- Filters + Add -->
  <form id="filterForm" method="GET" action="{{ route('popular_categories.index') }}"
        class="flex flex-wrap items-center justify-between gap-4 mb-6">

    <div class="flex items-center gap-3">
      <input
        id="popularCategorySearchInput"
        name="search"
        value="{{ request('search') }}"
        type="text"
        placeholder="Search Popular Categories"
        class="w-64 px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700
               dark:bg-gray-800 dark:text-gray-200 focus:outline-none focus:ring focus:ring-indigo-200"
      >
    </div>

    <div class="flex items-center gap-3">
      <label for="perPage" class="sr-only">Per page</label>
      <div class="relative">
        <select id="perPage" name="perPage"
                onchange="document.getElementById('filterForm').submit()"
                class="appearance-none rounded-lg border border-gray-300 dark:border-gray-700
                       dark:bg-gray-800 dark:text-gray-200 px-3 py-2 pr-8 focus:outline-none
                       focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
          @php $pp = request('perPage', request('per_page', 10)); @endphp
          <option value="10" {{ $pp == 10 ? 'selected' : '' }}>10</option>
          <option value="25" {{ $pp == 25 ? 'selected' : '' }}>25</option>
          <option value="50" {{ $pp == 50 ? 'selected' : '' }}>50</option>
        </select>
      </div>

      <!-- Export -->
      <button type="button" id="exportBtn"
        class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700
               dark:bg-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600">
        Export
      </button>

      <!-- Add Popular Category -->
      <button id="openDrawerBtn" type="button"
        class="px-4 py-2 rounded-lg bg-violet-600 text-white hover:bg-violet-700">
        + Add Popular Category
      </button>
    </div>
  </form>

  <!-- Flash Message -->
  @if (session('success'))
      <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
          {{ session('success') }}
      </div>
  @endif

  <!-- Table -->
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
      <thead class="bg-gray-50 dark:bg-gray-800">
        <tr>
          <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">#</th>
          <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Title</th>
          <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Department</th>
          <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Category</th>
          <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">SubCategory</th>
          <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Image</th>
          <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600 dark:text-gray-300">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
        @forelse($popularCategories as $item)
        <tr>
          <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ $loop->iteration }}</td>
          <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ $item->title }}</td>
          <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ $item->department?->name ?? '-' }}</td>
          <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ $item->category?->name ?? '-' }}</td>
          <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ $item->subCategory?->name ?? '-' }}</td>
          <td class="px-4 py-3">
            @if($item->image)
              <img src="{{ asset('storage/popular_categories/'.$item->image) }}"
                   class="h-12 w-12 object-cover rounded">
            @else
              <span class="text-gray-400">No Image</span>
            @endif
          </td>
          <td class="px-4 py-3 text-right">
            <div class="flex justify-end gap-2">
              <a href="{{ route('popular_categories.edit', $item->id) }}"
                 class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</a>
              <form action="{{ route('popular_categories.destroy', $item->id) }}" method="POST"
                    onsubmit="return confirm('Delete this item?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-500">Delete</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-300">
            No popular categories found.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Drawer -->
<div id="drawer"
     class="fixed inset-y-0 right-0 transform translate-x-full transition-transform duration-300 z-50
            w-full max-w-md bg-white dark:bg-gray-800 shadow-lg overflow-y-auto">
    <div class="p-6 relative">
        <!-- Close Button -->
        <button id="closeDrawerBtn" type="button"
                class="absolute top-4 right-4 text-gray-600 dark:text-gray-300 hover:text-gray-900
                       dark:hover:text-white text-2xl font-bold">&times;</button>

        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Add Popular Category</h1>

        <form action="{{ route('popular_categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium">Title</label>
                <input type="text" name="title" required
                       class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-700
                              dark:bg-gray-800 dark:text-white p-2" />
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Department</label>
                <select name="department_id" class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-700
                                                dark:bg-gray-800 dark:text-white p-2">
                    <option value="">-- Select Department --</option>
                    @foreach($departments as $dep)
                    <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Category</label>
                <select name="category_id" class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-700
                                                dark:bg-gray-800 dark:text-white p-2">
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">SubCategory</label>
                <select name="sub_category_id" class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-700
                                                    dark:bg-gray-800 dark:text-white p-2">
                    <option value="">-- Select SubCategory --</option>
                    @foreach($subCategories as $sub)
                    <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Desktop Image</label>
                <input type="file" name="banner_desktop_image"
                       class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-700
                              dark:bg-gray-800 dark:text-white p-2 border" />
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Mobile Image</label>
                <input type="file" name="banner_mobile_image"
                       class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-700
                              dark:bg-gray-800 dark:text-white p-2 border" />
            </div>

            <div class="flex justify-end gap-2">
                <button type="submit" class="px-4 py-2 rounded-lg bg-violet-600 text-white hover:bg-violet-700">
                    Save
                </button>
                <button type="button" id="drawerCancelBtn"
                        class="px-4 py-2 rounded-lg bg-red-100 text-red-500 hover:text-white hover:bg-red-500
                               dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JS Drawer -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const openDrawerBtn = document.getElementById('openDrawerBtn');
    const closeDrawerBtn = document.getElementById('closeDrawerBtn');
    const drawerCancelBtn = document.getElementById('drawerCancelBtn');
    const drawer = document.getElementById('drawer');
    const filterForm = document.getElementById('filterForm');
    const popularCategorySearchInput = document.getElementById('popularCategorySearchInput');
    let searchTimer = null;

    const openDrawer = () => drawer.classList.remove('translate-x-full');
    const closeDrawer = () => drawer.classList.add('translate-x-full');

    openDrawerBtn?.addEventListener('click', openDrawer);
    closeDrawerBtn?.addEventListener('click', closeDrawer);
    drawerCancelBtn?.addEventListener('click', closeDrawer);

    // Realtime search with debounce
    popularCategorySearchInput?.addEventListener('input', () => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            filterForm?.submit();
        }, 300);
    });
});
</script>

</x-app-layout>
