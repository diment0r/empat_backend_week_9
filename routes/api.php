<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('/users')->name('user.')->middleware('auth:sanctum')->controller(UserController::class)->group(function () {
    Route::get('/', 'index')->name('all');
});

Route::prefix('/auth')->name('auth.')->group(function () {
    Route::post('/register', [RegistrationController::class, 'register'])->name('register');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::delete('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum')->name('logout');
});

Route::prefix('/products')->name('product.')->middleware('auth:sanctum')->controller(ProductController::class)->group(function () {
    Route::post('/create', 'create')->name('create');
    Route::put('/update/{productId}', 'update')->name('update');
    Route::get('/', 'index')->name('all');
    Route::get('/product/{productId}', 'getProduct')->name('get');
    Route::get('/category/{categoryId}', 'getProductsByCategory')->name('get_by_category');
});

Route::prefix('/categories')->name('category.')->controller(CategoryController::class)->group(function () {
    Route::post('/create', 'create')->middleware('auth:sanctum')->name('create');
    Route::put('/update/{categoryId}', 'update')->middleware('auth:sanctum')->name('update');
    Route::get('/', 'index')->name('all');
    Route::get('/category/{categoryId}', 'getCategory')->name('get');
});
