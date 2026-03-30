
<x-app-layout>

    {{-- <div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-6xl mx-auto dark:text-white mb-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700"> --}}

        <!-- Heading -->
        {{-- <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 text-center">Collection List</h1> --}}

        <!-- Add Collections Button -->
        {{-- <div class="flex justify-end mb-4">
            <a href="{{ route('collections.create') }}"
               class="px-4 py-2 font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600">
                Add Collection
            </a>
        </div>

        <!-- Flash Message -->
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif --}}

        <!-- Collections Table -->
        {{-- <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Banner Image</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($collections as $collection)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $collection->title }}</td> --}}
                        {{-- <td class="px-6 py-4 whitespace-nowrap">{{ $collection->description }}</td> --}}
                        {{-- ................................. --}}

                        {{-- <td class="px-6 py-4 break-words max-w-xs">
                            {{ $collection->description }}
                        </td> --}}

                        {{-- ....................... --}}

                        {{-- <td class="px-6 py-4 whitespace-nowrap overflow-hidden text-ellipsis max-w-xs">
                            {{ $collection->description }}
                        </td> --}}

                        {{-- <td class="px-6 py-4 whitespace-nowrap">{{ $collection->banner_image }}</td> --}}
                        {{-- <td class="px-6 py-4 whitespace-nowrap">
                            @if ($collection->banner_image)
                                <img src="{{ asset('storage/' . $collection->banner_image) }}"
                                    alt="{{ $collection->title }}"
                                    class="h-16 w-16 object-cover rounded">
                            @else
                                <span class="text-gray-400">No Image</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="inline-flex space-x-2"> --}}
                                <!-- Edit Button -->
                                {{-- <a href="{{ route('collections.edit', $collection) }}"
                                   class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-500">
                                    Edit
                                </a>
                                 <a href="{{ route('collections.show', $collection) }}"
                                   class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-500">
                                    Show
                                </a> --}}

                                <!-- Delete Button -->
                                {{-- <form action="{{ route('collections.destroy', $collection) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this Collection?');">
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
    </div> --}}



    {{-- ............................................................................................................. --}}
    {{-- ................................................................................................................ --}}
    <div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-7xl mx-auto dark:text-white mb-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm">

  <!-- Heading -->
  <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 text-center border-b border-gray-200 dark:border-gray-700 pb-2">Collection List</h1>

  <!-- Filters + Add -->
  <form id="filterForm" method="GET" action="{{ route('collections.index') }}" class="flex flex-wrap items-center justify-between gap-4 mb-6">
    <div class="flex items-center gap-3">
      <input
        name="search"
        value="{{ request('search') }}"
        type="text"
        placeholder="Search Collections"
        class="w-64 px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 focus:outline-none focus:ring focus:ring-indigo-200"
        onkeydown="if(event.key === 'Enter'){ document.getElementById('filterForm').submit(); }"
      >
    </div>

    <div class="flex items-center gap-3">
      <label for="per_page" class="sr-only">Per page</label>
      <div class="relative">
        <select id="per_page" name="per_page" onchange="document.getElementById('filterForm').submit()"
                class="appearance-none rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 px-3 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
          @php $pp = request('per_page', 10); @endphp
          <option value="10" {{ $pp == 10 ? 'selected' : '' }}>10</option>
          <option value="25" {{ $pp == 25 ? 'selected' : '' }}>25</option>
          <option value="50" {{ $pp == 50 ? 'selected' : '' }}>50</option>
        </select>
      </div>

      <!-- Export selected -->
      <button type="button" id="exportBtn"
        class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600">
        Export
      </button>

      <!-- Add Collection -->
      <button id="openModalBtn" type="button"
        class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
        + Add Collection
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
          <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">
            <div class="flex items-center gap-2">
              <input type="checkbox" id="selectAll" class="form-checkbox rounded text-indigo-600">
              <span>ID</span>
            </div>
          </th>
          <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600 dark:text-gray-300">Name</th>
          <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600 dark:text-gray-300">Description</th>
          <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600 dark:text-gray-300">Banner</th>
          <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600 dark:text-gray-300">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
        @forelse ($collections as $collection)
        <tr>
          <td class="px-4 py-3">
            <div class="flex items-center gap-2">
              <input type="checkbox" class="form-checkbox rounded text-indigo-600 export-checkbox" value="{{ $collection->id }}">
              <span class="text-sm text-gray-800 dark:text-gray-200">{{ $loop->iteration + (($collections->currentPage()-1) * $collections->perPage()) }}</span>
            </div>
          </td>
          <td class="px-4 py-3 text-sm text-center text-gray-800 dark:text-gray-200">{{ $collection->title }}</td>
          <td class="px-4 py-3 text-sm text-center text-gray-800 dark:text-gray-200 break-words max-w-xs">{{ $collection->description }}</td>
          <td class="px-4 py-3 text-sm text-center text-gray-800 dark:text-gray-200">
            @if ($collection->banner_image)
              <img src="{{ asset('storage/' . $collection->banner_image) }}" alt="{{ $collection->title }}" class="h-16 w-16 object-cover rounded mx-auto">
            @else
              <span class="text-gray-400">No Image</span>
            @endif
          </td>
          <td class="px-4 py-3 text-right">
            <div class="flex items-center justify-end gap-2">
              <a href="{{ route('collections.edit', $collection) }}" class="inline-flex items-center p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg class="w-5 h-5 text-indigo-500" fill="currentColor" viewBox="0 0 20 20"><path d="M17.414 2.586a2 2 0 010 2.828L8.707 14.121a1 1 0 01-.464.263l-4 1a1 1 0 01-1.213-1.213l1-4a1 1 0 01.263-.464L14.586 2.586a2 2 0 012.828 0z"></path></svg>
              </a>
              <a href="{{ route('collections.show', $collection) }}" class="inline-flex items-center p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 11-7.938 7H2a1 1 0 100 2h.062A8 8 0 1110 2z"></path></svg>
              </a>
              <form action="{{ route('collections.destroy', $collection) }}" method="POST" onsubmit="return confirmDelete(event)" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                  <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path d="M6 2a1 1 0 00-1 1v1H3.5a.5.5 0 000 1H4v10a2 2 0 002 2h8a2 2 0 002-2V5h.5a.5.5 0 000-1H15V3a1 1 0 00-1-1H6zm2 5a.5.5 0 011 0v7a.5.5 0 01-1 0V7zm4 0a.5.5 0 011 0v7a.5.5 0 01-1 0V7z"></path></svg>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-300">No collections found.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Pagination Footer -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-4 py-3 border-t border-gray-200 dark:border-gray-700 mt-4">
    <div class="text-sm text-gray-600 dark:text-gray-400">
      @if ($collections->total() > 0)
        Showing {{ $collections->firstItem() }} to {{ $collections->lastItem() }} of {{ $collections->total() }} results
      @else
        Showing 0 to 0 of 0 results
      @endif
    </div>
    <div class="mt-3 sm:mt-0">
      {{ $collections->withQueryString()->links() }}
    </div>
  </div>



  {{-- ........................................................................................... --}}


  <!-- Drawer (Add Collection) -->
<div id="drawer" class="fixed inset-y-0 right-0 transform translate-x-full transition-transform duration-300 z-50 w-full max-w-md bg-white dark:bg-gray-800 shadow-lg overflow-y-auto">
    <div class="p-6">
        <!-- Close Button -->
        <button id="closeDrawerBtn" type="button"
                class="absolute top-4 right-4 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white text-2xl font-bold">
            &times;
        </button>

        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Add Collection</h1>

        <form method="POST" action="{{ route('collections.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Collection Title</label>
                <input type="text" name="title" id="title" required
                       class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white" />
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white"></textarea>
            </div>

            <div class="mb-4">
                <label for="banner_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Banner Image</label>
                <input type="file" name="banner_image" id="banner_image"
                       class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white border p-2 " />
            </div>

            <div class="flex justify-end gap-2">
                <button type="submit" class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                    Save
                </button>
                <button type="button" id="drawerCancelBtn" class="px-4 py-2 rounded-lg bg-red-100 text-red-500 hover:text-white hover:bg-red-500
                         dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>


</div>

<!-- SweetAlert2 & JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const openDrawerBtn = document.getElementById('openModalBtn'); // Add Collection button
    const closeDrawerBtn = document.getElementById('closeDrawerBtn'); // × button
    const drawerCancelBtn = document.getElementById('drawerCancelBtn'); // Cancel button
    const drawer = document.getElementById('drawer');

    if (!drawer) return; // safety check

    const openDrawer = () => drawer.classList.remove('translate-x-full');
    const closeDrawer = () => drawer.classList.add('translate-x-full');

    openDrawerBtn?.addEventListener('click', openDrawer);
    closeDrawerBtn?.addEventListener('click', closeDrawer);
    drawerCancelBtn?.addEventListener('click', closeDrawer);
});

// Confirm Delete Function
function confirmDelete(event) {
    event.preventDefault();
    const form = event.target.closest('form');
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this collection?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => { if (result.isConfirmed) form.submit(); });
    return false;
}
</script>



</x-app-layout>


