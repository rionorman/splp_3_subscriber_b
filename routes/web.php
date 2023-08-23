<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FrontendController;


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

Route::get('/welcome', function () {
    return view('welcome');
});

Auth::routes(['register' => true]);

Route::group(['middleware' => 'auth'], function () {
    Route::resource('category', CategoryController::class);
    Route::get('/category/{idcategory}/delete', [CategoryController::class, 'delete']);

    Route::resource('post', PostController::class);
    Route::get('/post/{idpost}/delete', [PostController::class, 'delete']);
});

Route::get('/', [FrontendController::class, 'beranda']);
Route::get('/home', [FrontendController::class, 'beranda']);
Route::get('/beranda', [FrontendController::class, 'beranda']);
Route::get('/detail/{id}', [FrontendController::class, 'detail']);

Route::get('/message', function () {
    return view('message');
});
