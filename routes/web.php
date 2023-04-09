<?php

use App\Http\Controllers\API\KategoriController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WEB\AdminController;
use App\Http\Controllers\WEB\KategoriServerSideController;
use App\Http\Controllers\WEB\ProductServerSideController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/api-kategori',[KategoriController::class,'index'])->name('api-kategori');
Route::get('/',[AdminController::class, 'dashboardView'])->name('dashboard');
Route::get('/kategori',[AdminController::class, 'kategoriView'])->name('kategori');
Route::get('/product',[AdminController::class, 'productView'])->name('product');

//serverside
Route::get('/server-kategori',[KategoriServerSideController::class,'getKategori'])->name('server-side-kategori');
Route::get('/view-kategori', [KategoriServerSideController::class, 'viewKategori'])->name('view-kategori');
Route::get('/server-product',[ProductServerSideController::class,'getProduct'])->name('server-side-product');
Route::get('/detail-price-product/{id_product}',[ProductServerSideController::class,'detailPriceProduct'])->name('detail-price-product');
Route::get('/server-price-product/{id}',[ProductServerSideController::class,'getPriceListProductDetail'])->name('server-price-product');
Route::get('/view-product', [ProductServerSideController::class, 'viewProduct'])->name('view-product');