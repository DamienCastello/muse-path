<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResouceController;
use App\Models\Track;
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

Route::prefix("/user")->name('user.')->controller(ProfileController::class)->group(function () {
    $idRegex = "[0-9]+";

    //Route::get("/", 'index')->name('index');

    Route::get('/{user}/contact','contact')->where([
        "user" => $idRegex,
    ])->name("contact")->middleware(['auth', 'verified']);

    Route::post('/{user}/contact','mail')->where([
        "user" => $idRegex,
    ])->name("mail")->middleware(['auth', 'verified']);

});

Route::prefix("/upload")->name('upload.')->group(function () {
    Route::get("/", function () {
        return view('upload.index');
    })->name('index');
});

Route::prefix("/resource")->name('resource.')->controller(ResouceController::class)->group(function () {
    $idRegex = "[0-9]+";
    $slugRegex = "[a-z0-9\-]+";

    Route::get("/", 'index')->name('index');

    Route::post('/{slug}-{resource}','comment')->where([
        "resource" => $idRegex,
        "slug" => $slugRegex
    ])->name("comment")->middleware(['auth', 'verified']);


    // Slug
    Route::get('/{slug}-{resource}', 'show')->where([
        "resource" => $idRegex,
        "slug" => $slugRegex
    ])->name("show");


    Route::prefix("/admin")->name("admin.")->group(function () {
        Route::get('/new', 'create')->name('create')->middleware(['auth', 'verified']);
        Route::post('/new', 'store')->middleware(['auth', 'verified']);
        Route::get('/{resource}/edit', 'edit')->name('edit')->middleware(['auth', 'verified']);
        Route::post('/{resource}/like', 'like')->name('like')->middleware(['auth', 'verified']);
        Route::patch('/{resource}/edit', 'update')->name('update')->middleware(['auth', 'verified']);
        Route::delete('/{resource}/delete', 'destroy')->name('delete')->middleware(['auth', 'verified']);
    });

});

Route::prefix("/track")->name('track.')->controller(\App\Http\Controllers\TrackController::class)->group(function () {
    $idRegex = "[0-9]+";

    Route::get("/", 'index')->name('index');

    Route::get('/{track}','show')->where([
        "track" => $idRegex,
    ])->name("show");

    Route::post('/{track}','feedback')->where([
        "resource" => $idRegex,
    ])->name("feedback")->middleware(['auth', 'verified']);



    Route::prefix("/admin")->name("admin.")->group(function () {
        Route::get('/new', 'create')->name('create')->can('create', Track::class)->middleware(['auth', 'verified']);
        Route::post('/new', 'store')->middleware(['auth', 'verified']);
        Route::post('/{track}/like', 'like')->name('like')->middleware(['auth', 'verified']);
        Route::delete('/{track}/delete', 'destroy')->can('delete', Track::class)->name('delete')->middleware(['auth', 'verified']);
    });

});

Route::prefix("/notification")->name('notification.')->controller(NotificationController::class)->group(function () {
    $idRegex = "[0-9]+";

    Route::get("/", 'index')->name('index');



    /*
    Route::prefix("/admin")->name("admin.")->group(function () {
        Route::get('/new', 'create')->name('create')->middleware(['auth', 'verified']);
        Route::post('/new', 'store')->middleware(['auth', 'verified']);
        Route::get('/{feedback}/edit', 'edit')->name('edit')->middleware(['auth', 'verified']);
        Route::post('/{feedback}/like', 'like')->name('like')->middleware(['auth', 'verified']);
        Route::patch('/{feedback}/edit', 'update')->name('update')->middleware(['auth', 'verified']);
        Route::delete('/{feedback}/delete', 'destroy')->name('delete')->middleware(['auth', 'verified']);
    });
    */
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
