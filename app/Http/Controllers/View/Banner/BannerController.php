<?php

namespace App\Http\Controllers\View\Banner;

use App\Models\Banner;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BannerController extends Controller
{

//       public function index()
//     {
//         $banners = Banner::all();
//         return view('admin.banner.index', compact('banners'));
//     }

//     public function create()
//     {
//         return view('admin.banner.create');
//     }

//     public function store(Request $request)
// {
//     // 1. Validation
//     $request->validate([
//         'title' => 'required|string|max:255',
//         'description' => 'nullable|string',
//         'banner_desktop_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
//         'banner_mobile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
//     ]);

//     $imagePath = null;

//     if ($request->hasFile('banner_desktop_image')) {
//         $image = $request->file('banner_desktop_image');

//         // original extension
//         $extension = $image->getClientOriginalExtension();

//         // clean title (replace spaces with underscores)
//         $title = preg_replace('/\s+/', '_', $request->title);

//         // new filename: title.timestamp.extension
//         $filename = $title . '_' . time() . '.' . $extension;

//         // save to banners folder inside public disk
//         $imagePath = $image->storeAs('banners', $filename, 'public');
//     }

//     if ($request->hasFile('banner_mobile_image')) {
//         $image = $request->file('banner_mobile_image');

//         // original extension
//         $extension = $image->getClientOriginalExtension();

//         // clean title (replace spaces with underscores)
//         $title = preg_replace('/\s+/', '_', $request->title);

//         // new filename: title.timestamp.extension
//         $filename = $title . '_' . time() . '.' . $extension;

//         // save to banners folder inside public disk
//         $imagePath = $image->storeAs('banners', $filename, 'public');
//     }

//     Banner::create([
//         'title' => $request->title,
//         'description' => $request->description,
//         'banner_desktop_image'=> $path,
//         'banner_mobile_image'=> $path,
//     ]);

//     return redirect()->route('banners.index')->with('success', 'Banner created successfully!');
// }


//     public function show(Banner $banner)
//     {
//         return view('admin.banner.show', compact('banner'));
//     }

//     public function edit(Banner $banner)
//     {
//         return view('admin.banner.edit', compact('banner'));
//     }

//     public function update(Request $request, Banner $banner)
//     {
//         $request->validate([
//             'title'        => 'required|string|max:255|unique:banners,title,' . $banner->id,
//             'description' => 'nullable|string',
//             'banner_desktop_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
//             'banner_mobile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
//         ]);

//         $path = $banner->banner_desktop_image;
//         if ($request->hasFile('banner_desktop_image')) {
//             // পুরানো image delete করো
//             if ($banner->banner_desktop_image && Storage::disk('public')->exists($banner->banner_desktop_image)) {
//                 Storage::disk('public')->delete($banner->banner_desktop_image);
//             }
//             $path = $request->file('banner_desktop_image')->store('banners', 'public');
//         }

//         $path = $banner->banner_mobile_image;
//         if ($request->hasFile('banner_mobile_image')) {
//             // পুরানো image delete করো
//             if ($banner->banner_mobile_image && Storage::disk('public')->exists($banner->banner_mobile_image)) {
//                 Storage::disk('public')->delete($banner->banner_mobile_image);
//             }
//             $path = $request->file('banner_mobile_image')->store('banners', 'public');
//         }

//         $banner->update([
//             'title'        => $request->title,
//             'description' => $request->description,
//             'banner_desktop_image'=> $path,
//             'banner_mobile_image'=> $path,
//         ]);

//         return redirect()->route('banners.index')->with('success', 'Banner updated successfully!');
//     }

//     public function destroy(Banner $banner)
//     {
//         if ($banner->banner_desktop_image && Storage::disk('public')->exists($banner->banner_desktop_image)) {
//             Storage::disk('public')->delete($banner->banner_desktop_image);
//         }

//         if ($banner->banner_mobile_image && Storage::disk('public')->exists($banner->banner_mobile_image)) {
//             Storage::disk('public')->delete($banner->banner_mobile_image);
//         }

//         $banner->delete();

//         return redirect()->back()->with('success', 'Banner deleted successfully!');
//     }



public function index(Request $request)
{
     $subCategories = SubCategory::all();
    $search   = $request->input('search');
    $perPage  = $request->input('perPage', 10);

    $query = Banner::with('subCategory');

    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('banner_desktop_image', 'like', "%{$search}%")
              ->orWhere('banner_mobile_image', 'like', "%{$search}%");
        });
    }

    // ================= EXPORT LOGIC =================
    if ($request->has('export_ids') && !empty($request->export_ids)) {
        $exportIds = $request->get('export_ids');

        $exportData = Banner::with('subCategory')
                            ->whereIn('id', $exportIds)
                            ->orderBy('title')
                            ->get();

        $filename = 'banners_export_' . date('Ymd_His') . '.csv';

        $response = new StreamedResponse(function() use ($exportData) {
            $handle = fopen('php://output', 'w');

            // CSV header
            fputcsv($handle, ['ID', 'Title', 'Desktop Image', 'Mobile Image', 'SubCategory', 'Created At']);

            // Data rows
            foreach ($exportData as $banner) {
                fputcsv($handle, [
                    $banner->id,
                    $banner->title,
                    $banner->banner_desktop_image,
                    $banner->banner_mobile_image,
                    $banner->subCategory->name ?? '-',
                    $banner->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");

        return $response;
    }
    // =================================================

    $banners = $query->orderBy('title')
                     ->paginate($perPage)
                     ->withQueryString();

    return view('admin.banner.index', compact('banners', 'subCategories'));
}



// public function index()
//     {
//         $banners = Banner::with('subCategory')->get(); // eager load relation
//         // $banners = Banner::all();
//         return view('admin.banner.index', compact('banners'));
//     }


    public function create()
{
    $subCategories = SubCategory::all();
    return view('admin.banner.create', compact('subCategories'));
}

// public function index(Request $request)
// {
//     $search = $request->input('search');
//     $perPage = $request->input('perPage', 10); // default 10 per page

//     $query = Department::query();

//     if ($search) {
//         $query->where('name', 'like', "%{$search}%");
//     }

//     // ================= EXPORT LOGIC =================
//     if ($request->has('export_ids')) {
//         $exportIds = $request->get('export_ids'); // array of selected IDs
//         $exportData = Department::whereIn('id', $exportIds)->orderBy('name')->get();

//         $filename = 'departments_export_'.date('Ymd_His').'.csv';

//         $response = new StreamedResponse(function() use ($exportData) {
//             $handle = fopen('php://output', 'w');

//             // CSV header
//             fputcsv($handle, ['ID', 'Name', 'Created At']);

//             // Data rows
//             foreach ($exportData as $dept) {
//                 fputcsv($handle, [
//                     $dept->id,
//                     $dept->name,
//                     $dept->created_at->format('Y-m-d H:i:s'),
//                 ]);
//             }

//             fclose($handle);
//         });

//         $response->headers->set('Content-Type', 'text/csv');
//         $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");

//         return $response;
//     }
//     // =================================================

//     $departments = $query->orderBy('name')->paginate($perPage)->withQueryString();

//     return view('admin.department.index', compact('departments'));
// }
// ...................................................................................................

    // public function create()
    // {
    //     return view('admin.banner.create');
    // }

    public function store(Request $request)
    {
        // 1. Validation
        $request->validate([
            'title' => 'required|string|max:255',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'banner_desktop_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner_mobile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'sub_category_id' => $request->sub_category_id,
        ];

        // 2. Desktop image
        if ($request->hasFile('banner_desktop_image')) {
            $data['banner_desktop_image'] = $request->file('banner_desktop_image')->store('banners/desktop', 'public');
        }

        // 3. Mobile image
        if ($request->hasFile('banner_mobile_image')) {
            $data['banner_mobile_image'] = $request->file('banner_mobile_image')->store('banners/mobile', 'public');
        }

        Banner::create($data);

        return redirect()->route('banners.index')->with('success', 'Banner created successfully!');
    }

    public function show(Banner $banner)
    {
        return view('admin.banner.show', compact('banner'));
    }

    // public function edit(Banner $banner)
    // {
    //     return view('admin.banner.edit', compact('banner'));
    // }

    public function edit(Banner $banner)
{
    $subCategories = \App\Models\SubCategory::all();
    return view('admin.banner.edit', compact('banner', 'subCategories'));
}


    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:banners,title,' . $banner->id,
            'sub_category_id' => 'required|exists:sub_categories,id',
            'banner_desktop_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner_mobile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'sub_category_id' => $request->sub_category_id,
        ];

        // Desktop image update
        if ($request->hasFile('banner_desktop_image')) {
            if ($banner->banner_desktop_image && Storage::disk('public')->exists($banner->banner_desktop_image)) {
                Storage::disk('public')->delete($banner->banner_desktop_image);
            }
            $data['banner_desktop_image'] = $request->file('banner_desktop_image')->store('banners/desktop', 'public');
        }

        // Mobile image update
        if ($request->hasFile('banner_mobile_image')) {
            if ($banner->banner_mobile_image && Storage::disk('public')->exists($banner->banner_mobile_image)) {
                Storage::disk('public')->delete($banner->banner_mobile_image);
            }
            $data['banner_mobile_image'] = $request->file('banner_mobile_image')->store('banners/mobile', 'public');
        }

        $banner->update($data);

        return redirect()->route('banners.index')->with('success', 'Banner updated successfully!');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->banner_desktop_image && Storage::disk('public')->exists($banner->banner_desktop_image)) {
            Storage::disk('public')->delete($banner->banner_desktop_image);
        }

        if ($banner->banner_mobile_image && Storage::disk('public')->exists($banner->banner_mobile_image)) {
            Storage::disk('public')->delete($banner->banner_mobile_image);
        }

        $banner->delete();

        return redirect()->back()->with('success', 'Banner deleted successfully!');
    }
}
