<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'index']);
Route::get('/fetch-products', [ProductController::class, 'fetchProducts']);
// Route::get('/', function () {
//     return view('welcome');
// });
