<x-app-layout>
    <div class="md:mt-6 px-4 sm:px-6 lg:px-8 py-8 w-full max-w-6xl mx-auto dark:text-white mb-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Edit Product</h1>

        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Product Name -->
                <div class="mb-4">
                    <label for="name" class="block font-medium">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="form-input w-full">
                    @error('name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <!-- Price -->
                <div class="mb-4">
                    <label for="price" class="block font-medium">Price</label>
                    <input type="text" name="price" id="price" value="{{ old('price', $product->price) }}" class="form-input w-full">
                    @error('price')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <!-- Old Price -->
                <div class="mb-4">
                    <label for="old_price" class="block font-medium">Old Price</label>
                    <input type="text" name="old_price" id="old_price" value="{{ old('old_price', $product->old_price) }}" class="form-input w-full">
                    @error('old_price')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <!-- Discount Percent -->
                <div class="mb-4">
                    <label for="discount_percent" class="block font-medium">Discount (%)</label>
                    <input type="text" name="discount_percent" id="discount_percent" value="{{ old('discount_percent', $product->discount_percent) }}" class="form-input w-full">
                    @error('discount_percent')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <!-- Manufacture Date -->
                <div class="mb-4">
                    <label for="manufactureDate" class="block font-medium">Manufacture Date</label>
                    <input type="date" name="manufactureDate" id="manufactureDate" value="{{ old('manufactureDate', $product->manufactureDate) }}" class="form-input w-full">
                    @error('manufactureDate')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <!-- Net Quantity -->
                <div class="mb-4">
                    <label for="netQuantity" class="block font-medium">Net Quantity</label>
                    <input type="text" name="netQuantity" id="netQuantity" value="{{ old('netQuantity', $product->net_quantity) }}" class="form-input w-full">
                    @error('netQuantity')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <!-- Disclaimer -->
                <div class="mb-4">
                    <label for="disclaimer" class="block font-medium">Disclaimer</label>
                    <input type="text" name="disclaimer" id="disclaimer" value="{{ old('disclaimer', $product->disclaimer) }}" class="form-input w-full">
                    @error('disclaimer')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <!-- Care Instructions -->
                <div class="mb-4">
                    <label for="careInstructions" class="block font-medium">Care Instructions</label>
                    <input type="text" name="careInstructions" id="careInstructions" value="{{ old('careInstructions', $product->care_instructions) }}" class="form-input w-full">
                    @error('careInstructions')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <!-- Brand -->
                <div class="mb-4">
                    <label for="brand" class="block font-medium">Brand</label>
                    <input type="text" name="brand" id="brand" value="{{ old('brand', $product->brand) }}" class="form-input w-full">
                    @error('brand')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <!-- Collection -->
                <div class="mb-4">
                    <label for="collection" class="block font-medium">Collection</label>
                    <input type="text" name="collection" id="collection" value="{{ old('collection', $product->collection) }}" class="form-input w-full">
                    @error('collection')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <!-- Color -->
                <div class="mb-4">
                    <label for="color" class="block font-medium">Color</label>
                    <input type="text" name="color" id="color" value="{{ old('color', $product->color) }}" class="form-input w-full">
                    @error('color')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <!-- Country of Origin -->
                <div class="mb-4">
                    <label for="countryOfOrigin" class="block font-medium">Country Of Origin</label>
                    <input type="text" name="countryOfOrigin" id="countryOfOrigin" value="{{ old('countryOfOrigin', $product->country_of_origin) }}" class="form-input w-full">
                    @error('countryOfOrigin')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <!-- Category -->
                <div>
                    <label class="block font-medium">Category</label>
                    <select name="category_id" id="category" class="border rounded w-full p-2">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
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

                <!-- Description -->
                <div>
                    <label class="block font-medium">Description</label>
                    <input type="text" name="description" value="{{ old('description', $product->description) }}" min="0" max="100" class="border rounded w-full p-2">
                </div>

                <!-- Old Images -->
                <div class="md:col-span-2">
                    <label class="block font-medium">Existing Images</label>
                    <div class="flex space-x-2 mb-2">
                        @foreach($product->images as $img)
                            <img src="{{ asset('storage/'.$img->image) }}" class="w-20 h-20 object-cover rounded border">
                        @endforeach
                    </div>
                </div>

                <!-- Product Images -->
                <div class="md:col-span-2">
                    <label class="block font-medium">Upload New Images</label>
                    <input type="file" name="images[]" multiple class="border rounded w-full p-2">
                    <p class="text-sm text-gray-500">Upload multiple images (first image will be default)</p>
                </div>

                <!-- Collections Multi-select -->
                <div class="md:col-span-2">
                    <label class="block font-medium">Collections</label>
                    <select name="collections[]" multiple class="border rounded w-full p-2">
                        @foreach($collections as $col)
                            <option value="{{ $col->id }}"
                                @if(in_array($col->id, $product->collections->pluck('id')->toArray())) selected @endif>
                                {{ $col->title }}
                            </option>
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
                                <input type="number" name="sizes[{{ $size->id }}]" value="{{ old('sizes.'.$size->id, $product->sizes->where('id',$size->id)->first()->pivot->quantity ?? 0) }}" min="0"
                                       class="border rounded w-full p-2">
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <button type="submit" class="btn bg-blue-600 text-white hover:bg-blue-700 mt-6">Update</button>
        </form>
    </div>

    <!-- Subcategory script -->
    <script>
        let categories = @json($categories);
        const oldSubId = "{{ old('sub_category_id', $product->sub_category_id) }}";

        document.getElementById('category').addEventListener('change', function () {
            let catId = this.value;
            let subSelect = document.getElementById('subcategory');
            subSelect.innerHTML = '<option value="">Select SubCategory</option>';

            let selectedCat = categories.find(c => c.id == catId);
            if (selectedCat && selectedCat.sub_categories) {
                selectedCat.sub_categories.forEach(sc => {
                    let selected = sc.id == oldSubId ? 'selected' : '';
                    subSelect.innerHTML += `<option value="${sc.id}" ${selected}>${sc.name}</option>`;
                });
            }
        });

        // Trigger change to populate old subcategory
        document.getElementById('category').dispatchEvent(new Event('change'));
    </script>
</x-app-layout>
