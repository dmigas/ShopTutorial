<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LoginController;

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

Route::get('/', [HomeController::class, 'index']);

Route::get('products', [ProductController::class, 'index']);
Route::get('products/create', [ProductController::class, 'create']);
Route::get('products/{product}', [ProductController::class, 'show']);
Route::get('products/{product}/edit', [ProductController::class, 'edit']);

Route::post('products', [ProductController::class, 'store']);
Route::patch('products/{product}/update', [ProductController::class, 'update']);
Route::delete('products/{product}/delete', [ProductController::class, 'destroy']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
