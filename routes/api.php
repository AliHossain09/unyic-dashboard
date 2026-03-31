<?php

use App\Http\Controllers\Api\Admin\Banner\BannerController;
use App\Http\Controllers\Api\Admin\Category\CategoryController;
use App\Http\Controllers\Api\Admin\Collection\CollectionController;
use App\Http\Controllers\Api\Admin\Department\DepartmentController;
use App\Http\Controllers\Api\Admin\MenuController\MenuController;
use App\Http\Controllers\Api\Admin\PopularCategory\PopularCategoryController;
use App\Http\Controllers\Api\Admin\Product\ProductController;
use App\Http\Controllers\Api\Admin\Size\SizeController;
use App\Http\Controllers\Api\Admin\SubCategory\SubCategoryController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\YourController;
use App\Http\Controllers\Api\Frontend\Cart\CartController as FrontCartController;
use App\Http\Controllers\Api\Frontend\Product\ProductController as FrontendProductController;

use App\Http\Controllers\Api\Frontend\Wishlist\WishlistController as FrontWishlistController;
use App\Http\Controllers\DataFeedController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Correct fallback for all OPTIONS requests (with nested paths)
Route::options('/{any}', function () {
    return response()->json([], 200);
})->where('any', '.*');

// Banner
Route::prefix('banners')->group(function () {
    Route::get('/', [BannerController::class, 'index']);
    Route::post('/', [BannerController::class, 'store']);
});

// Popular Categories
Route::prefix('popular-categories')->group(function () {
    Route::get('/', [PopularCategoryController::class, 'index']);
    Route::post('/', [PopularCategoryController::class, 'store']);
});

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Admin-only route
Route::middleware(['auth:sanctum', 'role:admin'])->get('/admin-data', function () {
    return response()->json(['message' => 'Welcome Admin']);
});

Route::middleware(['auth:sanctum', 'role:supervisor'])->get('/supervisor-data', function () {
    return response()->json(['message' => 'Welcome Supervisor']);
});

Route::middleware(['auth:sanctum', 'role:user'])->get('/user-dashboard', function () {
    return response()->json(['message' => 'Welcome to E-commerce']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    // Cart
    Route::get('/cart', [FrontCartController::class, 'index']);
    Route::post('/cart', [FrontCartController::class, 'store']);
    Route::delete('/cart/{id?}', [FrontCartController::class, 'destroy']);
    Route::put('/cart/{id}', [FrontCartController::class, 'update']);

    // Wishlist
    Route::get('/wishlist', [FrontWishlistController::class, 'index']);
    Route::post('/wishlist', [FrontWishlistController::class, 'store']);
    Route::delete('/wishlist/{productId?}', [FrontWishlistController::class, 'destroy']);
    // Route::delete('/wishlist/{id}', [FrontWishlistController::class, 'destroy']);
});

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/check-email', [YourController::class, 'checkEmail']);

// Protected routes (any authenticated user)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // });

    Route::get('/json-data-feed', [DataFeedController::class, 'getDataFeed']);
});

Route::middleware('auth:sanctum')->get('/user/details', function (Request $request) {
    if (! $request->user()) {
        return response()->json([
            'success' => false,
            'status' => 401,
            'message' => 'Unauthenticated. Please login first.',
        ], 401);
    }

    return response()->json([
        'success' => true,
        'data' => [
            'id' => $request->user()->id,
            'name' => $request->user()->name,
            'email' => $request->user()->email,
            'role' => $request->user()->role ?? null,
        ],
    ]);
});

Route::prefix('departments')->group(function () {
    Route::get('/', [DepartmentController::class, 'index']);
    Route::post('/', [DepartmentController::class, 'store']);
    Route::get('/{id}', [DepartmentController::class, 'show']);
    Route::put('/{id}', [DepartmentController::class, 'update']);
    Route::delete('/{id}', [DepartmentController::class, 'destroy']);
});

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::get('/{id}', [CategoryController::class, 'show']);
    Route::put('/{id}', [CategoryController::class, 'update']);
    Route::delete('/{id}', [CategoryController::class, 'destroy']);
});

Route::prefix('subCategories')->group(function () {
    Route::get('/', [SubCategoryController::class, 'index']);
    Route::post('/', [SubCategoryController::class, 'store']);
    Route::get('/{id}', [SubCategoryController::class, 'show']);
    Route::put('/{id}', [SubCategoryController::class, 'update']);
    Route::delete('/{id}', [SubCategoryController::class, 'destroy']);
});

Route::prefix('sizes')->group(function () {
    Route::get('/', [SizeController::class, 'index']);
    Route::post('/', [SizeController::class, 'store']);
    Route::get('/{id}', [SizeController::class, 'show']);
    Route::put('/{id}', [SizeController::class, 'update']);
    Route::delete('/{id}', [SizeController::class, 'destroy']);
});

// For API ( do frontend fetch )
Route::get('/menu', [MenuController::class, 'index']);

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/', [ProductController::class, 'store']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::put('/{id}', [ProductController::class, 'update']);
    Route::delete('/{id}', [ProductController::class, 'destroy']);
});

// =================== Products CRUD (Admin) ===================
Route::get('/products/popular', [ProductController::class, 'popular']);
Route::get('/products/new-arrivals', [ProductController::class, 'newArrivals']);
Route::get('/products/most-viewed', [ProductController::class, 'mostViewed']);

// Collections/ =================== Products CRUD (Admin) ===================
Route::prefix('collections')->group(function () {
    Route::get('/', [CollectionController::class, 'index']);
    Route::post('/', [CollectionController::class, 'store']);
});

// =================== Products (Frontend APIs) ===================
Route::prefix('frontend/products')->group(function () {
    Route::get('/popular', [FrontendProductController::class, 'popular']);
    Route::get('/new-arrivals', [FrontendProductController::class, 'newArrivals']);
    Route::get('/most-viewed', [FrontendProductController::class, 'mostViewed']);

    //  FILTER ROUTE
    Route::get('/', [FrontendProductController::class, 'getFilteredProducts']);
    Route::get('/filters', [FrontendProductController::class, 'getFilters']);
});

// Route::middleware('auth:sanctum')->get('/me', function () {
//     dd(auth()->user());
// });
