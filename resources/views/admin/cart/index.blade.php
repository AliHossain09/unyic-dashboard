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




<x-app-layout>

<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-6">Cart List</h1>

    @if($carts->isEmpty())
        <p class="text-gray-600">No cart items found.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left py-3 px-6 border-b border-gray-200">ID</th>
                        <th class="text-left py-3 px-6 border-b border-gray-200">Product Name</th>
                        <th class="text-left py-3 px-6 border-b border-gray-200">User</th>
                        <th class="text-left py-3 px-6 border-b border-gray-200">Size</th>
                        <th class="text-left py-3 px-6 border-b border-gray-200">Quantity</th>
                        <th class="text-left py-3 px-6 border-b border-gray-200">Price</th>
                        <th class="text-left py-3 px-6 border-b border-gray-200">Total</th>
                        <th class="text-left py-3 px-6 border-b border-gray-200">Added On</th>
                        <th class="text-right py-3 px-6 border-b border-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carts as $cart)
                        <tr class="hover:bg-gray-50">
                            <td class="py-4 px-6 border-b border-gray-200">{{ $cart->id }}</td>
                            <td class="py-4 px-6 border-b border-gray-200">{{ $cart->product->name ?? 'N/A' }}</td>
                            <td class="py-4 px-6 border-b border-gray-200">{{ $cart->user->name ?? 'N/A' }}</td>
                            <td class="py-4 px-6 border-b border-gray-200">{{ $cart->size ?? 'N/A' }}</td>
                            <td class="py-4 px-6 border-b border-gray-200">{{ $cart->quantity }}</td>
                            <td class="py-4 px-6 border-b border-gray-200">৳{{ number_format($cart->product->price ?? 0, 2) }}</td>
                            <td class="py-4 px-6 border-b border-gray-200">৳{{ number_format(($cart->product->price ?? 0) * $cart->quantity, 2) }}</td>
                            <td class="py-4 px-6 border-b border-gray-200">{{ $cart->created_at->format('d M Y, h:i A') }}</td>
                            <td class="py-4 px-6 border-b border-gray-200 text-right space-x-2">
                                <a href="{{ route('products.show', $cart->product->id ?? '') }}" target="_blank"
                                   class="inline-block px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">
                                    View
                                </a>

                                <form action="{{ route('cart.destroy', $cart->id) }}" method="POST" class="inline-block"
                                      onsubmit="return confirm('Are you sure you want to delete this cart item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

</x-app-layout>



