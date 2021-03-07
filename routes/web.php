<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;


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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/signup', [UserController::class, 'signup']);
Route::post('/login', [UserController::class, 'login']);
Route::put('/user/edit', [UserController::class, 'edit']);
Route::post('/products/get', [ProductController::class, 'get']);
Route::get('/categories/get', [CategoryController::class, 'get']);
Route::post('/setOrder', [OrderController::class, 'setOrder']);
Route::get('/history/get', [OrderController::class, 'historyGet']);
Route::post('/product/search', [ProductController::class, 'search']);



