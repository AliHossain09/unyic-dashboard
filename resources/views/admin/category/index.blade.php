{{-- <x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-6xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Category List</h1>

        <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left">#</th>
                    <th class="px-4 py-2 text-left">Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr class="border-t border-gray-200 dark:border-gray-700">
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ $category->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout> --}}


{{-- ................................................................................. --}}

<x-app-layout>

    {{-- <div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-6xl mx-auto dark:text-white mb-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">

        <!-- Heading -->
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 text-center">Category List</h1>

        <!-- Add Category Button -->
        <div class="flex justify-end mb-4">
            <a href="{{ route('categories.create') }}"
               class="px-4 py-2 font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600">
                Add Category
            </a>
        </div>

        <!-- Flash Message -->
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Category Table -->
        <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($categories as $category)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $category->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="inline-flex space-x-2">
                                <!-- Edit Button -->
                                <a href="{{ route('categories.edit', $category) }}"
                                   class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-500">
                                    Edit
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this category?');">
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





    {{-- .......................................... --}}
{{-- ...................................................................................................... --}}






  <div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-7xl mx-auto dark:text-white mb-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm">

    <!-- Heading -->
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 text-center border-b border-gray-200 dark:border-gray-700 pb-2">Category List</h1>

    <!-- Filters: one GET form so search + per_page stay in querystring -->
    <form id="filterForm" method="GET" action="{{ route('categories.index') }}" class="flex flex-wrap items-center justify-between gap-4 mb-6">
      <!-- Left: Search -->
      <div class="flex items-center gap-3">
        <input
          name="search"
          value="{{ request('search') }}"
          type="text"
          placeholder="Search Category"
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

        <!-- Add Dept (opens modal) -->
        <button id="openModalBtn" type="button"
          class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
          + Add Category
        </button>
      </div>
    </form>

    <!-- Table -->
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-800">
          <tr>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">
              <div class="flex items-center gap-2">
                <input type="checkbox" id="selectAll" class="form-checkbox rounded text-indigo-600">
                <span>Id</span>
              </div>
            </th>
            <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600 dark:text-gray-300">
              Name
            </th>
            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600 dark:text-gray-300">
              Actions
            </th>
          </tr>
        </thead>

        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
          @forelse ($categories as $category)
            <tr>
              <td class="px-4 py-3">
                <div class="flex items-center gap-2">
                  <input type="checkbox" class="form-checkbox rounded text-indigo-600 export-checkbox" value="{{ $category->id }}">
                  <span class="text-sm text-gray-800 dark:text-gray-200">{{ $loop->iteration + (($categories->currentPage()-1) * $categories->perPage()) }}</span>
                </div>
              </td>
              <td class="px-4 py-3 text-sm text-center text-gray-800 dark:text-gray-200">
                {{ $category->name }}
              </td>
              <td class="px-4 py-3 text-right">
                <div class="flex items-center justify-end gap-2">
                  <a href="{{ route('categories.edit', $category) }}" class="inline-flex items-center p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="w-5 h-5 text-indigo-500" fill="currentColor" viewBox="0 0 20 20"><path d="M17.414 2.586a2 2 0 010 2.828L8.707 14.121a1 1 0 01-.464.263l-4 1a1 1 0 01-1.213-1.213l1-4a1 1 0 01.263-.464L14.586 2.586a2 2 0 012.828 0z"></path></svg>
                  </a>
                  <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirmDelete(event)" class="inline-block">
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
              <td colspan="3" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-300">
                No categories found.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Footer + Pagination -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-4 py-3 border-t border-gray-200 dark:border-gray-700 mt-4">
      <div class="text-sm text-gray-600 dark:text-gray-400">
        @if ($categories->total() > 0)
          Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} results
        @else
          Showing 0 to 0 of 0 results
        @endif
      </div>

      <div class="mt-3 sm:mt-0">
        @if ($categories->lastPage() > 1)
          @php
            $current = $categories->currentPage();
            $last = $categories->lastPage();
            $start = max(1, $current - 2);
            $end = min($last, $current + 2);
          @endphp

          <nav class="inline-flex items-center space-x-1" role="navigation" aria-label="Pagination">
            @if ($current > 1)
              <a href="{{ request()->fullUrlWithQuery(['page' => $current - 1]) }}" class="inline-flex items-center px-3 py-1 border rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>Prev
              </a>
            @else
              <span class="inline-flex items-center px-3 py-1 border rounded-md opacity-50 cursor-not-allowed">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>Prev
              </span>
            @endif

            @if ($start > 1)
              <a href="{{ request()->fullUrlWithQuery(['page' => 1]) }}" class="px-3 py-1 border rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">1</a>
              @if ($start > 2)<span class="px-2">…</span>@endif
            @endif

            @for ($i = $start; $i <= $end; $i++)
              @if ($i == $current)
                <span aria-current="page" class="px-3 py-1 border rounded-md bg-indigo-600 text-white">{{ $i }}</span>
              @else
                <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}" class="px-3 py-1 border rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">{{ $i }}</a>
              @endif
            @endfor

            @if ($end < $last)
              @if ($end < $last - 1)<span class="px-2">…</span>@endif
              <a href="{{ request()->fullUrlWithQuery(['page' => $last]) }}" class="px-3 py-1 border rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">{{ $last }}</a>
            @endif

            @if ($current < $last)
              <a href="{{ request()->fullUrlWithQuery(['page' => $current + 1]) }}" class="inline-flex items-center px-3 py-1 border rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                Next<svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
              </a>
            @else
              <span class="inline-flex items-center px-3 py-1 border rounded-md opacity-50 cursor-not-allowed">
                Next<svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
              </span>
            @endif
          </nav>
        @endif
      </div>
    </div>

    <!-- Modal Dialog (Add Category) -->
    <div id="modalDialog" class="fixed inset-0 flex items-center justify-center hidden px-4 z-50">
      <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md">
        <button id="closeModalBtn" type="button"
          class="absolute top-2 right-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white text-2xl font-bold">
          &times;
        </button>
        <div class="p-6">
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
            <div class="flex justify-end gap-2">
              <button type="button" onclick="closeModal()"
                class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                Cancel
              </button>
              <button type="submit" class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                Save
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>

  <!-- SweetAlert2 (for delete confirm) -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const openModalBtn = document.getElementById('openModalBtn');
      const closeModalBtn = document.getElementById('closeModalBtn');
      const modalDialog = document.getElementById('modalDialog');
      const selectAll = document.getElementById('selectAll');
      const exportBtn = document.getElementById('exportBtn');

      openModalBtn?.addEventListener('click', () => modalDialog.classList.remove('hidden'));
      closeModalBtn?.addEventListener('click', () => modalDialog.classList.add('hidden'));
      modalDialog?.addEventListener('click', (e) => { if(e.target===modalDialog) modalDialog.classList.add('hidden'); });

      // Select/Deselect all
      selectAll?.addEventListener('change', (e) => {
        document.querySelectorAll('.export-checkbox').forEach(cb => cb.checked = e.target.checked);
      });

      // Export selected
      exportBtn?.addEventListener('click', () => {
        const selected = Array.from(document.querySelectorAll('.export-checkbox:checked')).map(cb => cb.value);
        if(selected.length === 0){
          Swal.fire('No Selection', 'Please select at least one category to export.', 'info');
          return;
        }
        const url = new URL(window.location.href);
        selected.forEach(id => url.searchParams.append('export_ids[]', id));
        window.location.href = url.toString();
      });
    });

    function confirmDelete(event) {
      event.preventDefault();
      const form = event.target.closest('form');
      Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this category?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => { if (result.isConfirmed) form.submit(); });
      return false;
    }

    function closeModal() {
      const modal = document.getElementById('modalDialog');
      if (modal) modal.classList.add('hidden');
    }
  </script>

</x-app-layout>


