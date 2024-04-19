<?php

use App\Http\Controllers\web\WebController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebController::class, 'index'])->name('home');
Route::get('/category', [WebController::class, 'category'])->name('category');
Route::get('/dish', [WebController::class, 'dish'])->name('dish');


// post
Route::post('/category/store', [WebController::class, 'save_dish'])->name('store');
Route::post('/category/edit', [WebController::class, 'update_dish'])->name('update');