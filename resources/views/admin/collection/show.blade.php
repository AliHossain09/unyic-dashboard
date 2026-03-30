{{-- <x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-900 dark:text-white">
            {{ $collection->name ?? $collection->title }}
        </h1>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            @if ($collection->banner_image)
                <img src="{{ asset('storage/' . $collection->banner_image) }}"
                     alt="{{ $collection->name ?? $collection->title }}"
                     class="w-full h-96 object-contain rounded mb-4" />
            @else
                <div class="w-full h-64 flex items-center justify-center bg-gray-100 dark:bg-gray-700 text-gray-400 rounded mb-4">
                    No Image Available
                </div>
            @endif

            <div class="">
                <strong >Description:</strong>
                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">
                    {{ $collection->description ?? 'No description provided.' }}
                </p>
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('collections.index') }}"
               class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Back to Collections
            </a>
        </div>
    </div>
</x-app-layout> --}}




<x-app-layout>
<section class="mt-12  py-3">
    <div class="bg-[#C2EFD4] mx-auto w-[1400px] relative flex justify-around items-center">

        <!-- dot disigne -->
        <div class="absolute left-10 bottom-0 w-[156px] h-[110px] grid grid-cols-4">
            @for ($i = 0; $i < 12; $i++)
                <div class="w-2 h-2 bg-[#328b55] rounded-full"></div>
            @endfor
        </div>

        <!-- image collection -->
        @if ($collection->banner_image)
            <img
                src="{{ asset('storage/' . $collection->banner_image) }}"
                alt="{{ $collection->name ?? $collection->title }}"
                class="max-w-[500px] h-[400px] object-contain rounded"
            />
        @else
            <div class="w-[500px] h-[400px] flex items-center justify-center bg-gray-100 text-gray-400 rounded">
                No Image Available
            </div>
        @endif

        <!-- collection details -->
        <div class="w-[589px] h-auto rounded-[3px]">
            <h2 class="text-[#224f34] text-[46px] font-bold font-['Roboto_Slab']">
                {{ $collection->name ?? $collection->title }}
            </h2>

            <p class="w-[589px] text-[#224f34] text-[22px] font-medium font-['Poppins'] leading-9 mt-4">
                {{ $collection->description ?? 'No description provided.' }}
            </p>


            <a href="{{ route('collections.index') }}">
                <button class="px-16 py-5 bg-[#224f34] rounded-[3px] shadow text-white text-xl font-medium font-['Poppins'] uppercase">
                    BACK TO COLLECTIONS
                </button>
            </a>
        </div>
    </div>
</section>


</x-app-layout>
