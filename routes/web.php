<?php

use App\Http\Controllers\API\KategoriController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WEB\AdminController;
use App\Http\Controllers\WEB\KategoriServerSideController;

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

Route::get('/api-kategori',[KategoriController::class,'index'])->name('api-kategori');
Route::get('/dashboard',[AdminController::class, 'dashboardView'])->name('dashboard');
Route::get('/kategori',[AdminController::class, 'kategoriView'])->name('kategori');
Route::get('/product',[AdminController::class, 'productView'])->name('product');

//serverside
Route::get('/server-kategori',[KategoriServerSideController::class,'getKategori'])->name('server-side-kategori');
Route::get('/view-kategori', [KategoriServerSideController::class, 'viewKategori'])->name('view-kategori');