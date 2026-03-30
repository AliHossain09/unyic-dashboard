{{--
<x-app-layout>
    <div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-6xl mx-auto dark:text-white mb-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">

        <!-- Heading -->
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 text-center">Banner List</h1>

        <!-- Add banners Button -->
        <div class="flex justify-end mb-4">
            <a href="{{ route('banners.create') }}"
               class="px-4 py-2 font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600">
                Add Banner
            </a>
        </div>

        <!-- Flash Message -->
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Collections Table -->
        <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sub Categoty</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Banner Desktop Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Banner Mobile Image</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($banners as $banner)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $banner->title }}</td>
                        <td class="px-6 py-4 break-words max-w-xs">{{ $banner->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($banner->banner_desktop_image)
                                <img src="{{ asset('storage/' . $banner->banner_image) }}"
                                    alt="{{ $banner->title }}"
                                    class="h-16 w-16 object-cover rounded">
                            @else
                                <span class="text-gray-400">No Image</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($banner->banner_mobile_image)
                                <img src="{{ asset('storage/' . $banner->banner_image) }}"
                                    alt="{{ $banner->title }}"
                                    class="h-16 w-16 object-cover rounded">
                            @else
                                <span class="text-gray-400">No Image</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="inline-flex space-x-2">
                                <!-- Edit Button -->
                                <a href="{{ route('banners.edit', $banner) }}"
                                   class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-500">
                                    Edit
                                </a>
                                 <a href="{{ route('banners.show', $banner) }}"
                                   class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-500">
                                    Show
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('banners.destroy', $banner) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this Banner?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-4 py-2 text-white bg-red-600 rounded-md hover:bg-red-500">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>

 --}}

 <x-app-layout>
    {{-- <div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-6xl mx-auto dark:text-white mb-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">

        <!-- Heading -->
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 text-center">Banner List</h1>

        <!-- Add banners Button -->
        <div class="flex justify-end mb-4">
            <a href="{{ route('banners.create') }}"
               class="px-4 py-2 font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600">
                Add Banner
            </a>
        </div>

        <!-- Flash Message -->
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Banners Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sub Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Desktop Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mobile Image</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($banners as $banner)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $banner->title }}</td>
                            <td class="px-6 py-4 break-words max-w-xs">
                                {{ $banner->subCategory->name ?? 'N/A' }}
                            </td>
                            <!-- Desktop Image -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($banner->banner_desktop_image)
                                    <img src="{{ asset('storage/' . $banner->banner_desktop_image) }}"
                                         alt="{{ $banner->title }}"
                                         class="h-16 w-16 object-cover rounded">
                                @else
                                    <span class="text-gray-400">No Image</span>
                                @endif
                            </td>
                            <!-- Mobile Image -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($banner->banner_mobile_image)
                                    <img src="{{ asset('storage/' . $banner->banner_mobile_image) }}"
                                         alt="{{ $banner->title }}"
                                         class="h-16 w-16 object-cover rounded">
                                @else
                                    <span class="text-gray-400">No Image</span>
                                @endif
                            </td>
                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="inline-flex space-x-2">
                                    <a href="{{ route('banners.edit', $banner) }}"
                                       class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-500">
                                        Edit
                                    </a>
                                    <a href="{{ route('banners.show', $banner) }}"
                                       class="px-4 py-2 text-white bg-gray-600 rounded-md hover:bg-gray-500">
                                        Show
                                    </a>
                                    <form action="{{ route('banners.destroy', $banner) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this Banner?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-4 py-2 text-white bg-red-600 rounded-md hover:bg-red-500">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @if($banners->isEmpty())
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No banners found.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div> --}}

     {{-- ............................................................................................................. --}}
    {{-- ................................................................................................................ --}}



<!-- admin/banner/index.blade.php -->

<div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-7xl mx-auto dark:text-white mb-6
            bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm">

  <!-- Heading -->
  <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 text-center
             border-b border-gray-200 dark:border-gray-700 pb-2">
      Banner List
  </h1>

  <!-- Filters + Add -->
  <form id="filterForm" method="GET" action="{{ route('banners.index') }}"
        class="flex flex-wrap items-center justify-between gap-4 mb-6">

    <div class="flex items-center gap-3">
      <input
        name="search"
        value="{{ request('search') }}"
        type="text"
        placeholder="Search Banners"
        class="w-64 px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700
               dark:bg-gray-800 dark:text-gray-200 focus:outline-none focus:ring focus:ring-indigo-200"
        onkeydown="if(event.key === 'Enter'){ document.getElementById('filterForm').submit(); }"
      >
    </div>

    <div class="flex items-center gap-3">
      <label for="per_page" class="sr-only">Per page</label>
      <div class="relative">
        <select id="per_page" name="per_page"
                onchange="document.getElementById('filterForm').submit()"
                class="appearance-none rounded-lg border border-gray-300 dark:border-gray-700
                       dark:bg-gray-800 dark:text-gray-200 px-3 py-2 pr-8 focus:outline-none
                       focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
          @php $pp = request('per_page', 10); @endphp
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

      <!-- Add Banner -->
      <button id="openDrawerBtn" type="button"
        class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
        + Add Banner
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
          <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Sub Category</th>
          <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Desktop</th>
          <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Mobile</th>
          <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600 dark:text-gray-300">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
        @forelse ($banners as $banner)
        <tr>
          <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ $loop->iteration }}</td>
          <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">{{ $banner->title }}</td>
          <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">
            {{ $banner->subCategory->name ?? 'N/A' }}
          </td>
          <td class="px-4 py-3">
            @if($banner->banner_desktop_image)
              <img src="{{ asset('storage/'.$banner->banner_desktop_image) }}"
                   class="h-12 w-12 object-cover rounded">
            @else
              <span class="text-gray-400">No Image</span>
            @endif
          </td>
          <td class="px-4 py-3">
            @if($banner->banner_mobile_image)
              <img src="{{ asset('storage/'.$banner->banner_mobile_image) }}"
                   class="h-12 w-12 object-cover rounded">
            @else
              <span class="text-gray-400">No Image</span>
            @endif
          </td>
          <td class="px-4 py-3 text-right">
            <div class="flex justify-end gap-2">
              <a href="{{ route('banners.edit', $banner) }}"
                 class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-500">Edit</a>
              <a href="{{ route('banners.show', $banner) }}"
                 class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-500">Show</a>
              <form action="{{ route('banners.destroy', $banner) }}" method="POST"
                    onsubmit="return confirm('Delete this banner?')" class="inline-block">
                @csrf @method('DELETE')
                <button type="submit"
                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-500">Delete</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-300">
            No banners found.
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

      <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Add Banner</h1>

      <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
          <label class="block text-sm font-medium">Title</label>
          <input type="text" name="title" required
                 class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-700
                        dark:bg-gray-800 dark:text-white p-2" />
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium">Sub Category</label>
          <select name="sub_category_id"
                  class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-700
                         dark:bg-gray-800 dark:text-white p-2">
            <option value="">-- Select Sub Category --</option>
            @foreach ($subCategories as $subCategory)
              <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
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

          <button type="submit"
                  class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
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
</div>

<!-- JS -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const openDrawerBtn = document.getElementById('openDrawerBtn');
  const closeDrawerBtn = document.getElementById('closeDrawerBtn');
  const drawerCancelBtn = document.getElementById('drawerCancelBtn');
  const drawer = document.getElementById('drawer');

  const openDrawer = () => drawer.classList.remove('translate-x-full');
  const closeDrawer = () => drawer.classList.add('translate-x-full');

  openDrawerBtn?.addEventListener('click', openDrawer);
  closeDrawerBtn?.addEventListener('click', closeDrawer);
  drawerCancelBtn?.addEventListener('click', closeDrawer);
});
</script>



</x-app-layout>

