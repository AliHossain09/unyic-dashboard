<?php

namespace App\Http\Controllers\Api\Frontend\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Size;
use App\Support\FrontendProductCache;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    private function requestCacheKey(string $prefix, Request $request): string
    {
        return FrontendProductCache::makeKey($prefix, $request->query());
    }

    private function rememberFromRedis(string $key, int $seconds, Closure $callback): mixed
    {
        try {
            return Cache::store('redis')->remember($key, $seconds, $callback);
        } catch (\Throwable $e) {
            Log::warning('Redis cache fallback used', [
                'key' => $key,
                'message' => $e->getMessage(),
            ]);

            return $callback();
        }
    }

    private function normalizeListingKey(?string $key): ?string
    {
        $normalized = strtolower(trim((string) $key));

        return match ($normalized) {
            'department', 'departments' => 'department',
            'category', 'categories' => 'category',
            'sub-category', 'sub_category', 'subcategory', 'sub-categories' => 'sub-category',
            default => null,
        };
    }

    private function normalizeSlug(?string $slug): ?string
    {
        if ($slug === null) {
            return null;
        }

        $slug = trim($slug);
        $slug = trim($slug, "\"'");

        return $slug === '' ? null : strtolower($slug);
    }

    private function applyKeyScope(Builder $query, Request $request): void
    {
        $key = $this->normalizeListingKey($request->query('key'));
        $keySlug = $this->normalizeSlug($request->query('keySlug'));

        if (! $key || ! $keySlug) {
            return;
        }

        switch ($key) {
            case 'department':
                $query->whereHas('category.department', function ($q) use ($keySlug) {
                    $q->where('slug', $keySlug);
                });
                break;
            case 'category':
                $query->whereHas('category', function ($q) use ($keySlug) {
                    $q->where('slug', $keySlug);
                });
                break;
            case 'sub-category':
                $query->whereHas('subCategory', function ($q) use ($keySlug) {
                    $q->where('slug', $keySlug);
                });
                break;
        }
    }

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
        $cacheTtl = (int) env('FRONTEND_FILTERS_CACHE_TTL', 120);
        $cacheKey = $this->requestCacheKey('frontend:products:filters', $request);

        $payload = $this->rememberFromRedis($cacheKey, $cacheTtl, function () use ($request) {
        // --------------------------------------------------------------------------
        // Query params
        // --------------------------------------------------------------------------
        $normalizeValues = static fn (array $values): array => collect($values)
            ->map(fn ($value) => strtolower(trim((string) $value)))
            ->filter()
            ->values()
            ->all();

        $selectedBrands = $normalizeValues((array) $request->query('brand', []));
        $selectedColors = $normalizeValues((array) $request->query('color', []));
        $selectedSizes = $normalizeValues((array) $request->query('size', []));
        $discountId = (int) $request->query('discount_id');
        $hasPriceFilter = $request->filled('price');

        [$minPrice, $maxPrice] = array_map(
            'intval',
            array_pad(explode('-', $request->query('price', '0-999999')), 2, 999999)
        );

        // --------------------------------------------------------------------------
        // Discount resolution
        // --------------------------------------------------------------------------
        $discountRules = $this->discountRules();
        $activeDiscount = $discountRules[$discountId] ?? null;

        $applyFilters = function (Builder $query, array $overrides = []) use (
            $request,
            $activeDiscount,
            $hasPriceFilter,
            $minPrice,
            $maxPrice,
            $selectedBrands,
            $selectedColors,
            $selectedSizes
        ): Builder {
            $this->applyKeyScope($query, $request);

            $applyDiscount = $overrides['apply_discount'] ?? true;
            $applyPrice = $overrides['apply_price'] ?? true;
            $brands = $overrides['brands'] ?? $selectedBrands;
            $colors = $overrides['colors'] ?? $selectedColors;
            $sizes = $overrides['sizes'] ?? $selectedSizes;

            if ($applyDiscount && $activeDiscount) {
                $query->whereBetween('discount_percent', $activeDiscount['range']);
            }

            if ($applyPrice && $hasPriceFilter) {
                $query->whereBetween('price', [$minPrice, $maxPrice]);
            }

            if ($brands) {
                $query->whereIn(DB::raw('LOWER(TRIM(brand))'), $brands);
            }

            if ($colors) {
                $query->whereIn(DB::raw('LOWER(TRIM(color))'), $colors);
            }

            if ($sizes) {
                $query->whereHas('sizes', function ($q) use ($sizes) {
                    $q->whereIn(DB::raw('LOWER(TRIM(sizes.name))'), $sizes);
                });
            }

            return $query;
        };

        // --------------------------------------------------------------------------
        // Price range for slider (depends on all active filters except price)
        // --------------------------------------------------------------------------
        $priceRangeQuery = Product::query();
        $applyFilters($priceRangeQuery, ['apply_price' => false]);
        $priceRangeForSlider = $priceRangeQuery
            ->selectRaw('MIN(price) as min, MAX(price) as max')
            ->first();

        // --------------------------------------------------------------------------
        // Discount counts (depends on all active filters except discount)
        // --------------------------------------------------------------------------
        $discountCountsQuery = Product::query();
        $applyFilters($discountCountsQuery, ['apply_discount' => false]);
        $discountCounts = $discountCountsQuery
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
        // Brand filters (depends on all active filters except brand)
        // --------------------------------------------------------------------------
        $brandQuery = Product::query();
        $applyFilters($brandQuery, ['brands' => []]);
        $brandFilters = $brandQuery
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
        // Color filters (depends on all active filters except color)
        // --------------------------------------------------------------------------
        $colorQuery = Product::query();
        $applyFilters($colorQuery, ['colors' => []]);
        $colorFilters = $colorQuery
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
        // Size filters (depends on all active filters except size)
        // --------------------------------------------------------------------------
        $sizeBaseQuery = Product::query();
        $applyFilters($sizeBaseQuery, ['sizes' => []]);
        $sizeFilters = Size::query()
            ->get()
            ->map(function ($size) use ($sizeBaseQuery) {
                $count = $size->products()
                    ->mergeConstraintsFrom(clone $sizeBaseQuery)
                    ->count();

                return [
                    'label' => ucfirst($size->name),
                    'count' => $count,
                ];
            })
            ->filter(fn ($size) => $size['count'] > 0)
            ->values();

        // --------------------------------------------------------------------------
        // Total products count for currently applied filters
        // --------------------------------------------------------------------------
        $filteredTotalQuery = Product::query();
        $applyFilters($filteredTotalQuery);
        $filteredTotal = $filteredTotalQuery->count();

        // --------------------------------------------------------------------------
        // Response
        // --------------------------------------------------------------------------
        return [
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
                'totalProductsCount' => $filteredTotal,
            ],
        ];
        });

        return response()->json($payload);
    }

    public function getFilteredProducts(Request $request)
    {
        $cacheTtl = (int) env('FRONTEND_PRODUCTS_CACHE_TTL', 60);
        $cacheKey = $this->requestCacheKey('frontend:products:list', $request);

        $payload = $this->rememberFromRedis($cacheKey, $cacheTtl, function () use ($request) {
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

        $defaultLimit = 20;
        $requestedLimit = $request->query('limit', $request->query('per_page', $defaultLimit));
        $limit = filter_var($requestedLimit, FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1],
        ]) ?: $defaultLimit;
        // Avoid requiring pagination=cursor param; use infinite scroll marker instead.
        $useCursorPagination = $request->boolean('infinite');

        // --------------------------------------------------------------------------
        // Discount resolution
        // --------------------------------------------------------------------------
        $discountRules = $this->discountRules();
        $activeDiscount = $discountRules[$discountId] ?? null;

        // --------------------------------------------------------------------------
        // Base product query
        // --------------------------------------------------------------------------
        $query = Product::query();
        $this->applyKeyScope($query, $request);

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

        // Keep total here for backward compatibility with existing frontend consumers.
        $includeTotal = $request->boolean('include_total', true);
        $total = $includeTotal ? (clone $query)->count() : null;

        // --------------------------------------------------------------------------
        // Sorting
        // --------------------------------------------------------------------------
        $sort = $request->query('sort', 'newest'); // default: newest
        switch ($sort) {
            case 'popular':
                $query->orderBy('views', 'desc');
                $query->orderBy('id', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                $query->orderBy('id', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                $query->orderBy('id', 'desc');
                break;
            case 'discount':
                $query->orderBy('discount_percent', 'desc');
                $query->orderBy('id', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                $query->orderBy('id', 'desc');
                break;
        }

        // --------------------------------------------------------------------------
        // Pagination with sizes eager loaded
        // --------------------------------------------------------------------------
        $query->with(['sizes', 'images']);

        // if ($useCursorPagination) {
        //     $products = $query->cursorPaginate(
        //         $limit,
        //         ['*'],
        //         'cursor',
        //         $request->query('cursor')
        //     );

        //     return response()->json([
        //         'data' => [
        //             'products' => ProductResource::collection($products->items()),
        //             'nextCursor' => $products->nextCursor()?->encode(),
        //             'total' => $total,
        //             'limit' => $limit,
        //         ],
        //     ]);
        // }

        
            $products = $query->cursorPaginate(
                $limit,
                ['*'],
                'cursor',
                $request->query('cursor')
            );

            return [
                'data' => [
                    'products' => ProductResource::collection($products->items())->toArray($request),
                    'nextCursor' => $products->nextCursor()?->encode(),
                    'total' => $total,
                    'limit' => $limit,
                ],
            ];
        });

        return response()->json($payload);
        

        // $products = $query->paginate($limit);

        // --------------------------------------------------------------------------
        // Response
        // --------------------------------------------------------------------------
        // return response()->json([
        //     'data' => [
        //         'products' => ProductResource::collection($products->items()),
        //         'total' => $products->total(),
        //         'limit' => $products->perPage(),
        //     ],
        // ]);
    }
}
