<?php

use App\Http\Controllers\ProfileController;
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

Route::prefix("/resource")->name('resource.')->controller(ResouceController::class)->group(function () {
    $idRegex = "[0-9]+";
    $slugRegex = "[a-z0-9\-]+";

    Route::get("/", 'index')->name('index');

    // Slug
    Route::get('/{slug}-{resource}', 'show')->where([
        "resource" => $idRegex,
        "slug" => $slugRegex
    ])->name("show");

    Route::prefix("admin")->name("admin.")->group(function () {
        Route::get('/new', 'create')->name('create')->middleware('auth');
        Route::post('/new', 'store')->middleware('auth');
        Route::get('/{resource}/edit', 'edit')->name('edit')->middleware('auth');
        Route::post('/{resource}/like', 'like')->name('like')->middleware('auth');
        Route::patch('/{resource}/edit', 'update')->name('update')->middleware('auth');
        Route::delete('/{resource}/delete', 'destroy')->name('delete')->middleware('auth');
    });

});

/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
