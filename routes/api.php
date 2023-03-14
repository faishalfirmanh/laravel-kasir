<?php

use App\Http\Controllers\API\KategoriController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::controller(KategoriController::class)->group(function () {
    Route::get('/kategori-byid/{id}', 'detail'); 
    Route::get('/kategori-detail', 'detail2'); 
    Route::get('/kategori-list', 'index'); 
    Route::post('/kategori-add', 'store');
    Route::post('/kategori-delete', 'remove');
});

Route::controller(ProductController::class)->group(function(){
    Route::get('/product-byid/{id}', 'detail'); 
    Route::get('/product-list', 'index'); 
    Route::post('/product-add', 'store');
    Route::post('/product-delete', 'remove');
});