<?php

use App\Http\Controllers\API\KategoriController;
use App\Http\Controllers\WEB\UserController as UserControllerWeb;
use App\Http\Controllers\WEB\TokoController;
use App\Http\Controllers\WEB\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WEB\AdminController;
use App\Http\Controllers\WEB\LaporanController;
use App\Http\Controllers\WEB\KasirController;
use App\Http\Controllers\WEB\KategoriServerSideController;
use App\Http\Controllers\WEB\ProductServerSideController;
use App\Http\Controllers\WEB\RoleController;

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

Route::get('/',[HomeController::class ,'pageHome'])->name('home');
Route::group(['middleware' => ['jwt.auth']], function() {
    Route::get('/dashboard',[AdminController::class, 'dashboardView'])->name('dashboard');
});


Route::get('/api-kategori',[KategoriController::class,'index'])->name('api-kategori');
   
    Route::get('/kategori-url',[AdminController::class, 'kategoriView'])->name('kategori-url');
    Route::get('/product',[AdminController::class, 'productView'])->name('product');

    //serverside
    Route::get('/server-kategori',[KategoriServerSideController::class,'getKategori'])->name('server-side-kategori');
    Route::get('/view-kategori', [KategoriServerSideController::class, 'viewKategori'])->name('view-kategori');
    Route::get('/server-product',[ProductServerSideController::class,'getProduct'])->name('server-side-product');
    Route::get('/detail-price-product/{id_product}',[ProductServerSideController::class,'detailPriceProduct'])->name('detail-price-product');
    Route::get('/server-price-product/{id}',[ProductServerSideController::class,'getPriceListProductDetail'])->name('server-price-product');
    Route::get('/view-product', [ProductServerSideController::class, 'viewProduct'])->name('view-product');
    Route::get('/view-user',[UserControllerWeb::class,'index'])->name('view-user');
    //toko
    Route::get('/view-toko',[TokoController::class,'viewToko'])->name('view-toko');
    Route::get('/server-side-toko',[TokoController::class, 'getToko'])->name('server-side-toko');

    //role
    Route::get('/view-role',[RoleController::class,'viewRole'])->name('view-role');
    Route::get('/server-side-role',[RoleController::class, 'getRole'])->name('server-side-role');

    //Kasir
    Route::get('/view-kasir',[KasirController::class,'viewKasir'])->name('view-kasir');
    Route::get('/invoice/{id}',[KasirController::class, 'viewInvoice'])->name('invoice');


    //laporan
    Route::get('/view-laporan',[LaporanController::class,'viewLaporan'])->name('view-laporan');
