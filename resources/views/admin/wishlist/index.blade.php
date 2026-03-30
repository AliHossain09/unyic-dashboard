<x-app-layout>
    <div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-6xl mx-auto dark:text-white mb-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg">

        <!-- Heading -->
        <h1 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-6">Wishlist List</h1>

        <!-- Flash Message -->
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Wishlist Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-sm">
                <thead>
                    <tr class="text-gray-500 dark:text-gray-300 uppercase text-xs tracking-wider">
                        <th class="px-6 py-3 text-left">#</th>
                        <th class="px-6 py-3 text-left">Product</th>
                        <th class="px-6 py-3 text-left">User</th>
                        <th class="px-6 py-3 text-left">Price</th>
                        <th class="px-6 py-3 text-left">Date</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 dark:text-gray-200">
                    @forelse ($wishlists as $wishlist)
                        @php
                            $product = $wishlist->product;
                            $user = $wishlist->user;
                        @endphp
                        <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900 transition">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>

                            <td class="px-6 py-4 whitespace-normal font-medium max-w-xs">
                                {{ $product->name ?? 'N/A' }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $user->name ?? 'Unknown' }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap font-semibold text-green-600">
                                ৳{{ number_format($product->price ?? 0, 2) }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $wishlist->created_at->format('d M Y, h:i A') }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right space-x-2">
                                {{-- View Product --}}
                                <a href="{{ route('products.show', $product->id) }}"
                                   class="inline-block px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded text-xs"
                                   target="_blank">
                                    View
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('wishlist.remove', $wishlist->id) }}" method="POST" class="inline-block"
                                      onsubmit="return confirm('Are you sure you want to delete this wishlist item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-4 py-2 text-white bg-red-600 hover:bg-red-700 rounded text-xs">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-gray-500 dark:text-gray-400">
                                No wishlist items found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
