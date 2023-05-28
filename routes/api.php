<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PostsTagsController;
use App\Http\Controllers\TagsController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('category/')->name('category.')->group(function () {
    Route::get('index', [CategoryController::class, 'index'])->name('index');
    Route::get('detail/{id}', [CategoryController::class, 'detail'])->name('detail');
    Route::post('store', [CategoryController::class, 'store'])->name('store');
    Route::post('update/{id}', [CategoryController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [CategoryController::class, 'delete'])->name('delete');
});

Route::prefix('tags/')->name('tags.')->group(function () {
    Route::get('index', [TagsController::class, 'index'])->name('index');
    Route::get('detail/{id}', [CategoryController::class, 'detail'])->name('detail');
    Route::post('store', [TagsController::class, 'store'])->name('store');
    Route::post('update/{id}', [TagsController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [TagsController::class, 'delete'])->name('delete');
});

Route::prefix('posts/')->name('posts.')->group(function () {
    Route::get('index', [PostsController::class, 'index'])->name('index');
    Route::get('detail/{id}', [CategoryController::class, 'detail'])->name('detail');
    Route::post('store', [PostsController::class, 'store'])->name('store');
    Route::post('update/{id}', [PostsController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [PostsController::class, 'delete'])->name('delete');
});
