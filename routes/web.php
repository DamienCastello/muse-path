<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('auth.login');
Route::delete('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'doLogin']);


Route::prefix("/product")->name('product.')->controller(\App\Http\Controllers\ProductController::class)->group(function () {
    Route::get("/", 'index')->name('index');
    Route::get('/new', 'create')->name('create')->middleware('auth');
    Route::post('/new', 'store')->middleware('auth');
    Route::get('/{product}/edit', 'edit')->name('edit')->middleware('auth');
    Route::patch('/{product}/edit', 'update')->middleware('auth');
    // Slug
    Route::get('/{slug}-{product}', 'show')->where([
        "product" => "[0-9]+",
        "slug" => "[a-z0-9\-]+"
    ])->name("show");
});


