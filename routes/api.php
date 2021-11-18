<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\UserController;
use Illuminate\Support\Facades\Route;

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
/**
 * Login / Register
 */
Route::prefix('auth')->group(static function () {
    Route::post('register', [AuthController::class, 'registration']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::get('category', [CategoryController::class, 'index']);
Route::get('category/{id}/products', [CategoryController::class, 'products']);
Route::get('product/{id}', [ProductController::class, 'show']);
Route::get('product/{id}/similar', [ProductController::class, 'similar']);
Route::get('search/{string}', [ProductController::class, 'search']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::get('me', [UserController::class, 'me']);
    Route::put('me', [UserController::class, 'update']);

    Route::post('category', [CategoryController::class, 'create']);
    Route::post('category/update', [CategoryController::class, 'update']);
    Route::delete('category/{id}', [CategoryController::class, 'delete']);

    Route::get('my/products', [ProductController::class, 'myProducts']);
    Route::post('product', [ProductController::class, 'create']);
    Route::post('product/update', [ProductController::class, 'update']);
    Route::delete('product/{id}', [ProductController::class, 'delete']);

});
