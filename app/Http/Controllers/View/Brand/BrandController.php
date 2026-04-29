<?php

namespace App\Http\Controllers\View\Brand;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = (int) $request->input('perPage', $request->input('per_page', 10));
        if (! in_array($perPage, [10, 25, 50], true)) {
            $perPage = 10;
        }

        $query = Brand::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($request->has('export_ids')) {
            $exportIds = $request->get('export_ids');
            $exportData = Brand::whereIn('id', $exportIds)->orderBy('name')->get();
            $filename = 'brands_export_'.date('Ymd_His').'.csv';

            return response()->streamDownload(function () use ($exportData) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['ID', 'Name', 'Slug', 'Created At']);

                foreach ($exportData as $brand) {
                    fputcsv($handle, [
                        $brand->id,
                        $brand->name,
                        $brand->slug,
                        $brand->created_at?->format('Y-m-d H:i:s'),
                    ]);
                }

                fclose($handle);
            }, $filename, [
                'Content-Type' => 'text/csv',
            ]);
        }

        $brands = $query->orderBy('name')->paginate($perPage)->withQueryString();

        return view('admin.brand.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brand.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
        ]);

        Brand::create([
            'name' => $request->name,
        ]);

        return redirect()->route('brands.index')->with('success', 'Brand added successfully!');
    }

    public function show(Brand $brand)
    {
        return view('admin.brand.show', compact('brand'));
    }

    public function edit(Brand $brand)
    {
        return view('admin.brand.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,'.$brand->id,
        ]);

        $brand->update([
            'name' => $request->name,
        ]);

        return redirect()->route('brands.index')->with('success', 'Brand updated successfully!');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->back()->with('success', 'Brand deleted successfully!');
    }
}
