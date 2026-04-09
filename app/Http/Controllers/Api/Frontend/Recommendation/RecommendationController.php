<?php

namespace App\Http\Controllers\Api\Frontend\Recommendation;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductInteraction;
use App\Support\GuestCookie;
use App\Support\ProductInteractionTracker;
use App\Support\ShoppingIdentity;
use App\Support\ShoppingScope;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RecommendationController extends Controller
{
    public function index(Request $request)
    {
        $identity = ShoppingIdentity::resolve($request);
        $limit = max(1, min(12, (int) $request->query('limit', 4)));

        $interactions = $this->recentInteractions($identity);

        if ($identity['type'] === 'guest') {
            ShoppingScope::touchGuestItems(ProductInteraction::class, $identity);
        }

        $products = $interactions->isEmpty()
            ? $this->fallbackProducts($limit)
            : $this->personalizedProducts($interactions, $limit);

        return $this->withGuestCookie($identity, response()->json([
            'success' => true,
            'message' => 'Recommended products fetched successfully',
            'is_personalized' => $interactions->isNotEmpty(),
            'data' => ProductResource::collection($products)->resolve($request),
        ]));
    }

    private function recentInteractions(array $identity): Collection
    {
        return ShoppingScope::apply(
            ProductInteraction::query()->with('product'),
            $identity
        )
            ->where('last_activity_at', '>=', now()->subDays(30))
            ->orderByDesc('last_activity_at')
            ->limit(50)
            ->get();
    }

    private function personalizedProducts(Collection $interactions, int $limit): Collection
    {
        $interactedProductIds = $interactions->pluck('product_id')->filter()->unique()->values();

        $categoryIds = $this->weightedIds($interactions, 'product.category_id');
        $subCategoryIds = $this->weightedIds($interactions, 'product.sub_category_id');
        $brandValues = $this->weightedBrands($interactions);

        $query = Product::query()
            ->with(['images', 'sizes', 'category', 'subCategory'])
            ->when($interactedProductIds->isNotEmpty(), fn ($q) => $q->whereNotIn('id', $interactedProductIds));

        if ($categoryIds->isNotEmpty() || $subCategoryIds->isNotEmpty() || $brandValues->isNotEmpty()) {
            $query->where(function ($builder) use ($categoryIds, $subCategoryIds, $brandValues) {
                if ($categoryIds->isNotEmpty()) {
                    $builder->orWhereIn('category_id', $categoryIds->all());
                }

                if ($subCategoryIds->isNotEmpty()) {
                    $builder->orWhereIn('sub_category_id', $subCategoryIds->all());
                }

                if ($brandValues->isNotEmpty()) {
                    $builder->orWhereIn(DB::raw('LOWER(TRIM(brand))'), $brandValues->all());
                }
            });
        }

        if ($subCategoryIds->isNotEmpty()) {
            $query->orderByRaw($this->fieldOrderSql('sub_category_id', $subCategoryIds));
        }

        if ($categoryIds->isNotEmpty()) {
            $query->orderByRaw($this->fieldOrderSql('category_id', $categoryIds));
        }

        if ($brandValues->isNotEmpty()) {
            $brandList = $brandValues->map(fn ($brand) => "'".str_replace("'", "''", $brand)."'")->implode(', ');
            $query->orderByRaw("CASE WHEN LOWER(TRIM(brand)) IN ({$brandList}) THEN 0 ELSE 1 END");
        }

        $recommended = $query
            ->orderByDesc('views')
            ->orderByDesc('is_new')
            ->limit($limit)
            ->get();

        if ($recommended->count() >= $limit) {
            return $recommended;
        }

        $excludedIds = $interactedProductIds
            ->merge($recommended->pluck('id'))
            ->unique()
            ->values();

        return $recommended->concat(
            $this->fallbackProducts($limit - $recommended->count(), $excludedIds)
        );
    }

    private function fallbackProducts(int $limit, ?Collection $excludeIds = null): Collection
    {
        return Product::query()
            ->with(['images', 'sizes', 'category', 'subCategory'])
            ->when($excludeIds?->isNotEmpty(), fn ($q) => $q->whereNotIn('id', $excludeIds->all()))
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    private function weightedIds(Collection $interactions, string $path): Collection
    {
        return $interactions
            ->groupBy(fn ($interaction) => data_get($interaction, $path))
            ->map(fn ($items, $id) => [
                'id' => (int) $id,
                'score' => $items->sum('score'),
            ])
            ->filter(fn ($item) => $item['id'] > 0)
            ->sortByDesc('score')
            ->pluck('id')
            ->take(5)
            ->values();
    }

    private function weightedBrands(Collection $interactions): Collection
    {
        return $interactions
            ->groupBy(function ($interaction) {
                $brand = strtolower(trim((string) data_get($interaction, 'product.brand')));

                return $brand !== '' ? $brand : null;
            })
            ->filter(fn ($items, $brand) => $brand !== null)
            ->map(fn ($items) => $items->sum('score'))
            ->sortDesc()
            ->keys()
            ->take(5)
            ->values();
    }

    private function fieldOrderSql(string $field, Collection $values): string
    {
        $cases = $values
            ->values()
            ->map(fn ($value, $index) => "WHEN {$field} = ".(int) $value.' THEN '.$index)
            ->implode(' ');

        return "CASE {$cases} ELSE 999 END";
    }

    protected function withGuestCookie(array $identity, $response)
    {
        if ($identity['type'] === 'guest' && $identity['guest_token']) {
            $response->cookie(GuestCookie::make($identity['guest_token']));
        }

        return $response;
    }
}
