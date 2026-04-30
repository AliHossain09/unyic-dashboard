<x-app-layout>
    <div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-6xl mx-auto dark:text-white mb-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Add Product</h1>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Grid 2 columns -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Product Name -->
                <div>
                    <label class="block font-medium">Product Name</label>
                    <input type="text" name="name" class="border rounded w-full p-2">
                </div>

                <!-- Price -->
                <div>
                    <label class="block font-medium">Price</label>
                    <input type="number" step="0.01" name="price" class="border rounded w-full p-2">
                </div>

                <!-- Old Price -->
                <div>
                    <label class="block font-medium">Old Price</label>
                    <input type="number" step="0.01" name="old_price" class="border rounded w-full p-2">
                </div>

                <!-- Discount Percent -->
                <div>
                    <label class="block font-medium">Discount (%)</label>
                    <input type="number" name="discount_percent" min="0" max="100" class="border rounded w-full p-2">
                </div>

                <!-- Manufacture Date -->
                <div>
                    <label class="block font-medium">Manufacture Date</label>
                    <input type="date" name="manufactureDate" class="border rounded w-full p-2">
                </div>

                <!-- Net Quantity  -->
                <div>
                    <label class="block font-medium">Net Quantity</label>
                    <input type="text" name="netQuantity"  class="border rounded w-full p-2">
                </div>

                <!-- Disclaimer  -->
                <div>
                    <label class="block font-medium">Disclaimer</label>
                    <input type="text" name="disclaimer"  class="border rounded w-full p-2">
                </div>

                <!-- Care Instructions  -->
                <div>
                    <label class="block font-medium">Care Instructions</label>
                    <input type="text" name="careInstructions"  class="border rounded w-full p-2">
                </div>

                <!-- Brand -->
                <div>
                    <label class="block font-medium">Brand</label>
                    <select name="brand_id" class="border rounded w-full p-2">
                        <option value="">Select Brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" @selected(old('brand_id') == $brand->id)>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-sm text-gray-500 mt-1">Select an existing brand or type a new one below.</p>
                    <input type="text" name="brand_name" value="{{ old('brand_name') }}" placeholder="New brand name" class="border rounded w-full p-2 mt-2">
                    @error('brand_id')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                    @error('brand_name')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                </div>

                <!-- Collection -->
                <div>
                    <label class="block font-medium">Collection</label>
                    <input type="text" name="collection" class="border rounded w-full p-2">
                </div>

                <!-- Color -->
                <div>
                    <label class="block font-medium">Color</label>
                    <input type="text" name="color" class="border rounded w-full p-2">
                </div>

                <!-- Country of Origin -->
                <div>
                    <label class="block font-medium">Country Of Origin</label>
                    <input type="text" name="countryOfOrigin" class="border rounded w-full p-2">
                </div>

                <!-- Category -->
                <div>
                    <label class="block font-medium">Category</label>
                    <select name="category_id" id="category" class="border rounded w-full p-2">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>


                <!-- SubCategory -->
                <div>
                    <label class="block font-medium">SubCategory</label>
                    <select name="sub_category_id" id="subcategory" class="border rounded w-full p-2">
                        <option value="">Select SubCategory</option>
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="block font-medium">Status</label>
                    <select name="status" id="status" class="border rounded w-full p-2">
                        <option value="publish" @selected(old('status', 'publish') === 'publish')>Publish</option>
                        <option value="scheduled" @selected(old('status') === 'scheduled')>Scheduled</option>
                        <option value="inactive" @selected(old('status') === 'inactive')>Inactive</option>
                    </select>
                </div>

                <!-- Publish At -->
                <div id="publishAtWrap">
                    <label class="block font-medium">Publish At</label>
                    <input type="datetime-local" name="publish_at" id="publish_at" value="{{ old('publish_at') }}" class="border rounded w-full p-2">
                </div>

                <!-- Description Date -->
                <div>
                    <label class="block font-medium">Description</label>
                    <input type="text" name="description" min="0" max="100" class="border rounded w-full p-2">
                </div>

                <!-- Product Images -->
                <div class="md:col-span-2">
                    <label class="block font-medium">Product Images</label>
                    <input type="file" name="images[]" multiple class="border rounded w-full p-2">
                    <p class="text-sm text-gray-500">Upload multiple images (first image will be the default)</p>
                </div>

                <!-- Collections (Multi-select) -->
                <div class="md:col-span-2">
                    <label class="block font-medium">Collections</label>
                    <select name="collections[]" multiple class="border rounded w-full p-2">
                        @foreach($collections as $col)
                            <option value="{{ $col->id }}">{{ $col->title }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Sizes & Quantities -->
                <div class="md:col-span-2">
                    <h3 class="font-semibold mb-2">Sizes & Quantities</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($sizes as $size)
                            <div class="flex items-center space-x-2">
                                <label class="w-12">{{ $size->name }}</label>
                                <input type="number" name="sizes[{{ $size->id }}]" value="0" min="0"
                                       class="border rounded w-full p-2">
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- Popular / New -->
            <div class="flex items-center space-x-6">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="is_popular" value="1">
                    <span>Popular Product</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="is_new" value="1">
                    <span>New Arrival</span>
                </label>
            </div>

            <!-- Submit -->
            <div>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">
                    Save Product
                </button>
            </div>
        </form>
    </div>

    <!-- Subcategory script -->
    <script>
        let categories = @json($categories);

        const categoryEl = document.getElementById('category');
        const statusEl = document.getElementById('status');
        const publishAtWrapEl = document.getElementById('publishAtWrap');
        const publishAtInputEl = document.getElementById('publish_at');

        categoryEl.addEventListener('change', function () {
            let catId = this.value;
            let subSelect = document.getElementById('subcategory');
            subSelect.innerHTML = '<option value="">Select SubCategory</option>';

            let selectedCat = categories.find(c => c.id == catId);
            if (selectedCat && selectedCat.sub_categories) {
                selectedCat.sub_categories.forEach(sc => {
                    subSelect.innerHTML += `<option value="${sc.id}">${sc.name}</option>`;
                });
            }
        });

        function togglePublishAt() {
            if (!statusEl || !publishAtWrapEl || !publishAtInputEl) return;
            const scheduled = statusEl.value === 'scheduled';
            publishAtWrapEl.style.display = scheduled ? 'block' : 'none';
            publishAtInputEl.required = scheduled;
        }

        if (statusEl) {
            statusEl.addEventListener('change', togglePublishAt);
            togglePublishAt();
        }
    </script>
</x-app-layout>

<!--  -->
