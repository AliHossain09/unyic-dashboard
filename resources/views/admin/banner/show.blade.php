<x-app-layout>
<section class="mt-12  py-3">
    <div class="bg-[#C2EFD4] mx-auto w-[1400px] relative flex justify-around items-center">

        <!-- dot disigne -->
        <div class="absolute left-10 bottom-0 w-[156px] h-[110px] grid grid-cols-4">
            @for ($i = 0; $i < 12; $i++)
                <div class="w-2 h-2 bg-[#328b55] rounded-full"></div>
            @endfor
        </div>

        <!-- Banned Desktop image -->
        @if ($banner->banner_desktop_image)
            <img
                src="{{ asset('storage/' . $banner->banner_desktop_image) }}"
                alt="{{ $banner->name ?? $banner->title }}"
                class="max-w-[500px] h-[400px] object-contain rounded"
            />
        @else
            <div class="w-[500px] h-[400px] flex items-center justify-center bg-gray-100 text-gray-400 rounded">
                No Desktop Image   Available
            </div>
        @endif
        <!-- Banned Mobile image -->
        @if ($banner->banner_mobile_image)
            <img
                src="{{ asset('storage/' . $banner->banner_mobile_image) }}"
                alt="{{ $banner->name ?? $banner->title }}"
                class="max-w-[500px] h-[400px] object-contain rounded"
            />
        @else
            <div class="w-[500px] h-[400px] flex items-center justify-center bg-gray-100 text-gray-400 rounded">
                No Bobile Image Available
            </div>
        @endif

        <!-- banner details -->
        <div class="w-[589px] h-auto rounded-[3px]">
            <h2 class="text-[#224f34] text-[46px] font-bold font-['Roboto_Slab']">
                {{ $banner->name ?? $banner->title }}
            </h2>

            <p class="w-[589px] text-[#224f34] text-[22px] font-medium font-['Poppins'] leading-9 mt-4">
                {{ $banner->sub_category ?? 'No description provided.' }}
            </p>


            <a href="{{ route('banners.index') }}">
                <button class="px-16 py-5 bg-[#224f34] rounded-[3px] shadow text-white text-xl font-medium font-['Poppins'] uppercase">
                    BACK TO Banner
                </button>
            </a>
        </div>
    </div>
</section>


</x-app-layout>
