<?php

namespace App\Http\Controllers\View\SpotlightBrand;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SpotlightBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SpotlightBrandController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = (int) $request->input('perPage', 10);

        if (! in_array($perPage, [10, 25, 50], true)) {
            $perPage = 10;
        }

        $query = SpotlightBrand::query();

        if ($search) {
            $query->where('brand', 'like', "%{$search}%");
        }

        $spotlightBrands = $query
            ->orderBy('serial')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.spotlightBrands.index', [
            'spotlightBrands' => $spotlightBrands,
        ]);
    }

    public function create()
    {
        return view('admin.spotlightBrands.create', [
            'brands' => $this->availableBrands(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        $this->ensureActiveLimit($request->boolean('is_active'));

        $validated['image'] = $request->file('image')->store('spotlight_brands', 'public');
        $validated['is_active'] = $request->boolean('is_active', true);

        SpotlightBrand::create($validated);

        return redirect()
            ->route('spotlight_brands.index')
            ->with('success', 'Spotlight brand created successfully.');
    }

    public function show(SpotlightBrand $spotlightBrand)
    {
        return view('admin.spotlightBrands.show', compact('spotlightBrand'));
    }

    public function edit(SpotlightBrand $spotlightBrand)
    {
        return view('admin.spotlightBrands.edit', [
            'spotlightBrand' => $spotlightBrand,
            'brands' => $this->availableBrands(),
        ]);
    }

    public function update(Request $request, SpotlightBrand $spotlightBrand)
    {
        $validated = $this->validateRequest($request, $spotlightBrand);
        $validated['is_active'] = $request->boolean('is_active');

        $this->ensureActiveLimit($validated['is_active'], $spotlightBrand);

        if ($request->hasFile('image')) {
            if ($spotlightBrand->image && Storage::disk('public')->exists($spotlightBrand->image)) {
                Storage::disk('public')->delete($spotlightBrand->image);
            }

            $validated['image'] = $request->file('image')->store('spotlight_brands', 'public');
        }

        $spotlightBrand->update($validated);

        return redirect()
            ->route('spotlight_brands.index')
            ->with('success', 'Spotlight brand updated successfully.');
    }

    public function destroy(SpotlightBrand $spotlightBrand)
    {
        if ($spotlightBrand->image && Storage::disk('public')->exists($spotlightBrand->image)) {
            Storage::disk('public')->delete($spotlightBrand->image);
        }

        $spotlightBrand->delete();

        return redirect()
            ->route('spotlight_brands.index')
            ->with('success', 'Spotlight brand deleted successfully.');
    }

    public function toggleStatus(SpotlightBrand $spotlightBrand)
    {
        $newStatus = ! $spotlightBrand->is_active;
        $this->ensureActiveLimit($newStatus, $spotlightBrand);

        $spotlightBrand->update([
            'is_active' => $newStatus,
        ]);

        return redirect()
            ->route('spotlight_brands.index')
            ->with('success', 'Spotlight brand status updated successfully.');
    }

    private function validateRequest(Request $request, ?SpotlightBrand $spotlightBrand = null): array
    {
        $spotlightBrandId = $spotlightBrand?->id;

        return $request->validate([
            'brand' => [
                'required',
                'string',
                'max:255',
                Rule::unique('spotlight_brands', 'brand')->ignore($spotlightBrandId),
            ],
            'serial' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('spotlight_brands', 'serial')->ignore($spotlightBrandId),
            ],
            'image' => [
                $spotlightBrand ? 'nullable' : 'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }

    private function ensureActiveLimit(bool $shouldBeActive, ?SpotlightBrand $spotlightBrand = null): void
    {
        if (! $shouldBeActive) {
            return;
        }

        $activeCount = SpotlightBrand::query()
            ->where('is_active', true)
            ->when($spotlightBrand, fn ($query) => $query->whereKeyNot($spotlightBrand->id))
            ->count();

        if ($activeCount >= 2) {
            throw ValidationException::withMessages([
                'is_active' => 'Only 2 spotlight brands can be active at a time.',
            ]);
        }
    }

    private function availableBrands(): array
    {
        $brands = Product::query()
            ->whereNotNull('brand')
            ->whereRaw("TRIM(brand) != ''")
            ->selectRaw('TRIM(brand) as brand')
            ->distinct()
            ->orderBy('brand')
            ->pluck('brand')
            ->all();

        return array_values(array_unique($brands));
    }
}
