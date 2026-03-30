<?php

namespace App\Http\Controllers\Api\Frontend\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private function discountRules(): array
    {
        return [
            1 => ['label' => '0% - 20%',  'range' => [0, 20]],
            2 => ['label' => '21% - 40%', 'range' => [21, 40]],
            3 => ['label' => '41% - 60%', 'range' => [41, 60]],
            4 => ['label' => '61% - 80%', 'range' => [61, 80]],
            5 => ['label' => '81% - 100%', 'range' => [81, 100]],
        ];
    }

    public function getFilters(Request $request)
    {
        // --------------------------------------------------------------------------
        // Query params
        // --------------------------------------------------------------------------
        $selectedBrands = array_filter((array) $request->query('brand', []));
        $selectedColors = array_filter((array) $request->query('color', []));
        $discountId = (int) $request->query('discount_id');

        [$minPrice, $maxPrice] = array_map(
            'intval',
            array_pad(explode('-', $request->query('price', '0-999999')), 2, 999999)
        );

        // --------------------------------------------------------------------------
        // Discount resolution
        // --------------------------------------------------------------------------
        $discountRules = $this->discountRules();
        $activeDiscount = $discountRules[$discountId] ?? null;

        // --------------------------------------------------------------------------
        // Base query (discount only for slider)
        // --------------------------------------------------------------------------
        $baseQuery = Product::query();

        if ($activeDiscount) {
            $baseQuery->whereBetween('discount_percent', $activeDiscount['range']);
        }

        // --------------------------------------------------------------------------
        // Price range for slider (ignores user price filter)
        // --------------------------------------------------------------------------
        $priceRangeForSlider = (clone $baseQuery)
            ->selectRaw('MIN(price) as min, MAX(price) as max')
            ->first();

        // --------------------------------------------------------------------------
        // Apply price filter for actual product listing
        // --------------------------------------------------------------------------
        if ($request->filled('price')) {
            $baseQuery->whereBetween('price', [$minPrice, $maxPrice]);
        }

        // --------------------------------------------------------------------------
        // Discount counts (always based on all products)
        // --------------------------------------------------------------------------
        $discountCounts = Product::query()
            ->selectRaw('
            SUM(discount_percent BETWEEN 0 AND 20)   as d1,
            SUM(discount_percent BETWEEN 21 AND 40)  as d2,
            SUM(discount_percent BETWEEN 41 AND 60)  as d3,
            SUM(discount_percent BETWEEN 61 AND 80)  as d4,
            SUM(discount_percent BETWEEN 81 AND 100) as d5
        ')
            ->first();

        $discountFilters = collect($discountRules)->map(function ($rule, $id) use ($discountCounts) {
            $countKey = 'd'.$id;

            return [
                'id' => $id,
                'label' => $rule['label'],
                'count' => (int) ($discountCounts->$countKey ?? 0),
            ];
        })->filter(fn ($d) => $d['count'] > 0)->values();

        // --------------------------------------------------------------------------
        // Brand filters (depends on discount + price)
        // --------------------------------------------------------------------------
        $brandFilters = (clone $baseQuery)
            ->whereNotNull('brand')
            ->selectRaw('LOWER(TRIM(brand)) as value, COUNT(*) as count')
            ->groupBy('value')
            ->orderBy('value')
            ->get()
            ->map(fn ($b) => [
                'label' => ucfirst($b->value),
                'count' => $b->count,
            ]);

        // --------------------------------------------------------------------------
        // Color filters (depends on discount + price + selected brands)
        // --------------------------------------------------------------------------
        $colorFilters = (clone $baseQuery)
            ->when($selectedBrands, fn ($q) => $q->whereIn('brand', $selectedBrands))
            ->whereNotNull('color')
            ->selectRaw('LOWER(TRIM(color)) as value, COUNT(*) as count')
            ->groupBy('value')
            ->orderBy('value')
            ->get()
            ->map(fn ($c) => [
                'label' => ucfirst($c->value),
                'count' => $c->count,
            ]);

        // --------------------------------------------------------------------------
        // Size filters (depends on discount + price + selected brands + colors)
        // --------------------------------------------------------------------------
        $sizeFilters = Size::query()
            ->whereHas('products', function ($q) use ($baseQuery, $selectedBrands, $selectedColors) {
                $q->mergeConstraintsFrom($baseQuery);

                if ($selectedBrands) {
                    $q->whereIn('brand', $selectedBrands);
                }

                if ($selectedColors) {
                    $q->whereIn('color', $selectedColors);
                }
            })
            ->get()
            ->map(fn ($size) => [
                'label' => ucfirst($size->name),
                'count' => $size->products()
                    ->mergeConstraintsFrom($baseQuery)
                    ->when($selectedBrands, fn ($q) => $q->whereIn('brand', $selectedBrands))
                    ->when($selectedColors, fn ($q) => $q->whereIn('color', $selectedColors))
                    ->count(),
            ]);

        // --------------------------------------------------------------------------
        // Response
        // --------------------------------------------------------------------------
        return response()->json([
            'data' => [
                'discount' => [
                    'options' => $discountFilters,
                    'active_discount_id' => $activeDiscount ? $discountId : null,
                ],
                'price' => [
                    'min' => (int) ($priceRangeForSlider->min ?? 0),
                    'max' => (int) ($priceRangeForSlider->max ?? 0),
                ],
                'brand' => $brandFilters,
                'color' => $colorFilters,
                'size' => $sizeFilters,
            ],
        ]);
    }

    public function getFilteredProducts(Request $request)
    {
        // --------------------------------------------------------------------------
        // Query params
        // --------------------------------------------------------------------------
        $selectedBrands = array_filter((array) $request->query('brand', []));
        $selectedColors = array_filter((array) $request->query('color', []));
        $selectedSizes = array_filter((array) $request->query('size', []));
        $discountId = (int) $request->query('discount_id');
        [$minPrice, $maxPrice] = array_map(
            'intval',
            array_pad(explode('-', $request->query('price', '0-999999')), 2, 999999)
        );

        $perPage = (int) $request->query('per_page', 20); // default pagination

        // --------------------------------------------------------------------------
        // Discount resolution
        // --------------------------------------------------------------------------
        $discountRules = $this->discountRules();
        $activeDiscount = $discountRules[$discountId] ?? null;

        // --------------------------------------------------------------------------
        // Base product query
        // --------------------------------------------------------------------------
        $query = Product::query();

        // Discount filter
        if ($activeDiscount) {
            $query->whereBetween('discount_percent', $activeDiscount['range']);
        }

        // Price filter
        if ($request->filled('price')) {
            $query->whereBetween('price', [$minPrice, $maxPrice]);
        }

        // Brand filter
        if ($selectedBrands) {
            $query->whereIn('brand', $selectedBrands);
        }

        // Color filter
        if ($selectedColors) {
            $query->whereIn('color', $selectedColors);
        }

        // Size filter
        if ($selectedSizes) {
            $query->whereHas('sizes', function ($q) use ($selectedSizes) {
                $q->whereIn('sizes.name', $selectedSizes);
            });
        }

        // --------------------------------------------------------------------------
        // Sorting
        // --------------------------------------------------------------------------
        $sort = $request->query('sort', 'newest'); // default: newest
        switch ($sort) {
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'discount':
                $query->orderBy('discount_percent', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // --------------------------------------------------------------------------
        // Pagination with sizes eager loaded
        // --------------------------------------------------------------------------
        $products = $query->with('sizes')->paginate($perPage);

        // --------------------------------------------------------------------------
        // Response
        // --------------------------------------------------------------------------
        return response()->json([
            'data' => ProductResource::collection($products->items()),
        ]);
    }
}
