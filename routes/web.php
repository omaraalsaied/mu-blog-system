<?php

use App\Http\Controllers\PostImageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);



Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/posts', \App\Http\Controllers\PostController::class)
        ->name('show', 'posts.show')
        ->name('create', 'posts.create')
        ->name('store', 'posts.store')
        ->name('edit', 'posts.edit')
        ->name('update', 'posts.update')
        ->name('destroy', 'posts.destroy');
    Route::get('user_posts', [\App\Http\Controllers\PostController::class, 'user_posts'])->name('posts.user_posts');
    Route::delete('/post_image/{id}', [\App\Http\Controllers\PostController::class, 'deleteImage']);
    Route::post('/upload-photos', [PostImageController::class, 'upload']);
});
    Route::get('/', [\App\Http\Controllers\PostController::class, 'index'])->name('index');

require __DIR__.'/auth.php';
