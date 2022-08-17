<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ProductDetailsController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\CartController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Api\FrontendController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




Route::post('register', [AuthController::class,'register']);
Route::post('login', [AuthController::class, 'login']);

// JOHN DATA

Route::get('getCategory', [FrontendController::class,'category']);
Route::get('fetchproducts/{slug}', [FrontendController::class, 'product']);
Route::get('viewproductdetail/{slug}/{product_slug}', [FrontendController::class, 'viewproduct']);
Route::get('allproduct', [FrontendController::class, 'index']);
Route::post('addcart', [CartController::class, 'addtocart']);

Route::middleware(['auth:sanctum','isAPIAdmin'])->group(function(){

    Route::get('/checkingAuthenticated', function() {
        return response()->json(['message'=>'You are in', 'status'=>200], 200);
    });
    //Brand
    Route::get('view-brand', [BrandController::class, 'index']);
    Route::post('store-brand', [BrandController::class, 'store']);
    Route::get('edit-brand/{id}', [BrandController::class, 'edit']);
    Route::put('update-brand/{id}', [BrandController::class, 'update']);
    Route::delete('delete-brand/{id}', [BrandController::class, 'destroy']);

    //Role
    Route::get('view-role', [RoleController::class, 'index']);
    Route::post('store-role', [RoleController::class, 'store']);
    Route::get('edit-role/{id}', [RoleController::class, 'edit']);
    Route::put('update-role/{id}', [RoleController::class, 'update']);
    Route::delete('delete-role/{id}', [RoleController::class, 'destroy']);

    //Category
    Route::get('view-category', [CategoryController::class, 'index']);
    Route::post('store-category', [CategoryController::class, 'store']);
    Route::get('edit-category/{id}', [CategoryController::class, 'edit']);
    Route::put('update-category/{id}', [CategoryController::class, 'update']);
    Route::delete('delete-category/{id}', [CategoryController::class, 'destroy']);
    Route::get('all-category', [CategoryController::class, 'allcategory']);



    //Products
    Route::post('store-product', [ProductController::class, 'store']);
    Route::get('view-product', [ProductController::class, 'index']);
});

Route::middleware(['auth:sanctum'])->group(function(){

    Route::post('logout', [AuthController::class, 'logout']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
