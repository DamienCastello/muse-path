<?php

use App\Http\Controllers\ResouceController;
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

Route::prefix("/resource")->name('resource.')->controller(ResouceController::class)->group(function () {
    Route::get("/", 'index')->name('index');
    Route::get('/new', 'create')->name('create')->middleware('auth');
    Route::post('/new', 'store')->middleware('auth');
    Route::get('/{resource}/edit', 'edit')->name('edit')->middleware('auth');
    Route::post('/{resource}/like', 'like')->name('like')->middleware('auth');
    Route::patch('/{resource}/edit', 'update')->name('update')->middleware('auth');
    Route::delete('/{resource}/delete', 'destroy')->name('delete')->middleware('auth');
    // Slug
    Route::get('/{slug}-{resource}', 'show')->where([
        "resource" => "[0-9]+",
        "slug" => "[a-z0-9\-]+"
    ])->name("show");
});


