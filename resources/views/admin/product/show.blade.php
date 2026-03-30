<x-app-layout>
    <div
        x-data="{
            currentImage: '{{ $product->images->firstWhere('is_default', true)?->image ?? $product->images->first()?->image ?? '' }}'
        }"
        class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8"
    >
        <!-- Page Title -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 text-center">Product Details</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">

            <!-- Images Section -->
            <div>
                <!-- Main Image -->
                <div class="aspect-w-1 aspect-h-1 w-full rounded-lg overflow-hidden border border-gray-300 dark:border-gray-700">
                    <template x-if="currentImage">
                        <img
                            :src="'{{ asset('storage') }}/' + currentImage"
                            alt="Main Product Image"
                            class="object-cover w-full h-full transition duration-300 ease-in-out"
                        >
                    </template>
                    <template x-if="!currentImage">
                        <div class="flex items-center justify-center h-full text-gray-400">
                            No Image Available
                        </div>
                    </template>
                </div>

                <!-- Thumbnail Gallery -->
                @if($product->images->count() > 1)
                    <div class="flex gap-3 mt-4 overflow-x-auto">
                        @foreach($product->images as $image)
                            <img
                                src="{{ asset('storage/' . $image->image) }}"
                                alt="Thumbnail"
                                class="w-20 h-20 object-cover rounded border border-gray-300 dark:border-gray-600 cursor-pointer hover:opacity-75 transition"
                                :class="currentImage === '{{ $image->image }}' ? 'ring-2 ring-blue-500' : ''"
                                @click="currentImage = '{{ $image->image }}'"
                            >
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Details -->
            <div class="space-y-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $product->name }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Created {{ $product->created_at->diffForHumans() }}</p>
                </div>

                @if ($product->description)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-white">Description</h3>
                        <p class="text-gray-600 dark:text-gray-300">{{ $product->description }}</p>
                    </div>
                @endif

                <div>
                    <p class="text-xl font-semibold text-green-600 dark:text-green-400">
                        ${{ number_format($product->price, 2) }}
                    </p>
                    @if($product->old_price)
                        <p class="text-sm line-through text-red-500">
                            ${{ number_format($product->old_price, 2) }}
                        </p>
                    @endif
                </div>

                <div class="flex gap-2">
                    @if ($product->is_new)
                        <span class="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded">New</span>
                    @endif
                    @if ($product->is_popular)
                        <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded">Popular</span>
                    @endif
                </div>

                <!-- Sizes & Stock -->
                @if ($product->sizes->count())
                    <div>
                        <h3 class="text-lg font-semibold mb-2 text-gray-700 dark:text-white">Available Sizes</h3>
                        <div class="flex flex-wrap gap-3">
                            @foreach($product->sizes as $size)
                                <div class="relative group">
                                    <span
                                        class="px-3 py-1 rounded-full text-sm font-medium
                                               {{ $size->pivot->quantity > 0
                                                    ? 'bg-green-100 text-green-700 border border-green-400'
                                                    : 'bg-red-100 text-red-600 border border-red-400' }}">
                                        {{ $size->name }}
                                    </span>

                                    <span class="absolute hidden group-hover:block
                                                 text-white text-xs rounded px-2 py-1
                                                 -top-8 left-1/2 transform -translate-x-1/2 whitespace-nowrap
                                                 {{ $size->pivot->quantity > 0 ? 'bg-gray-800' : 'bg-red-700' }}">
                                        {{ $size->pivot->quantity > 0 ? 'Stock: ' . $size->pivot->quantity : 'Out of Stock' }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Collections -->
                @if($product->collections->count())
                    <div>
                        <h3 class="text-lg font-semibold mb-2 text-gray-700 dark:text-white">Collections</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($product->collections as $collection)
                                <span class="px-2 py-1 text-xs bg-purple-100 text-purple-800 rounded">
                                    {{ $collection->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Meta Info -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-600 dark:text-gray-300">
                    @if($product->brand)
                        <p><strong>Brand:</strong> {{ $product->brand }}</p>
                    @endif
                    @if($product->color)
                        <p><strong>Color:</strong> {{ $product->color }}</p>
                    @endif
                    @if($product->country_of_origin)
                        <p><strong>Made in:</strong> {{ $product->country_of_origin }}</p>
                    @endif
                    @if($product->manufacture_date)
                        <p><strong>Manufactured:</strong> {{ $product->manufacture_date }}</p>
                    @endif
                    @if($product->net_quantity)
                        <p><strong>Net Quantity:</strong> {{ $product->net_quantity }}</p>
                    @endif
                    @if($product->care_instructions)
                        <p><strong>Care:</strong> {{ $product->care_instructions }}</p>
                    @endif
                    @if($product->disclaimer)
                        <p class="sm:col-span-2"><strong>Disclaimer:</strong> {{ $product->disclaimer }}</p>
                    @endif
                </div>

                <!-- Edit Button -->
                <div>
                    <a href="{{ route('products.edit', $product) }}"
                       class="inline-block px-4 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700">
                        Edit Product
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Alpine.js CDN (only add this if Alpine is NOT loaded globally) --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</x-app-layout>
