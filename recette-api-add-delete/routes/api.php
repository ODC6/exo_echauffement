<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\DishController;
use App\Http\Controllers\api\ReviewsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/v1/admin/auth/login', [AuthController::class, 'login_admin']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/v1/admin/auth/logout', [AuthController::class, 'logout']);



    // dish management
    Route::post('/v1/admin/dish/store', [DishController::class, 'store_dish']);
    Route::delete('/v1/admin/dish/delete', [DishController::class, 'delete_dish']);

    Route::delete('/v1/admin/reviews/delete', [ReviewsController::class, 'delete_reviews']);
});
// category management
Route::post('/v1/admin/category/store', [CategoryController::class, 'store_category']);
Route::delete('/v1/admin/category/delete', [CategoryController::class, 'delete_category']);


// user management
Route::post('/v1/user/store', [AuthController::class, 'store_user']);


// reviews management
Route::post('/v1/user/reviews/store', [ReviewsController::class, 'store_reviews']);
