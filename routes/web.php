<?php

use Illuminate\http\Request;
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



Route::prefix("/product")->name('product.')->controller(\App\Http\Controllers\ProductController::class)->group(function () {

    Route::get("/", 'index')->name('index');

    // Slug
    Route::get('/{slug}-{id}', 'show')->where([
        "id" => "[0-9]+",
        "slug" => "[a-z0-9\-]+"
    ])->name("show");
});

/* ---------------------------------------------------------------------------------------------------------------
Sandbox

Route::get('/', function () {
    return view('welcome');
});

// LARAVEL TRAIN ROUTE
// Get param
Route::get('/page/param', function (Request $request) {
    return [
        "name" => $request->input("name", "John Doe"),
        "all" => $request->all()
    ];
});

Route::prefix("/page")->group(function () {
    // FORMAT LINK ROUTE WITH PARAM
    Route::get("/", function (Request $request) {
        return [
            "Link" => \route("page.slug.show", ["slug" => "jackpot", "id" => 777])
        ];
    })->name("index");

    // Slug
    Route::get('/{slug}-{id}', function (string $slug, string $id, Request $request) {
        return [
            "slug" => $slug,
            "id" => $id,
            "name" => $request->input("name")
        ];
    })->where([
        "id" => "[0-9]+",
        "slug" => "[a-z0-9\-]+"
    ])->name("show");
});
 ---------------------------------------------------------------------------------------------------------------*/
