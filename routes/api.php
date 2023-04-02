<?php

use App\Http\Controllers\API\KategoriController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\UserController;
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

Route::post('login',[UserController::class,'loginUser'])->name('login');
Route::post('logout-api',[UserController::class,'logouttess'])->name('logout-api');


Route::group(['middleware' => ['jwt.verify']], function() {
    //--use jwt--
    Route::controller(KategoriController::class)->group(function () {
        Route::get('/kategori-byid/{id}', 'detail')->name('kategori-details-byId'); 
        Route::get('/kategori-detail', 'detail2')->name('kategori-details'); 
        Route::get('/kategori-details-input','detailKategori')->name('kategori-details-input');
        Route::get('/kategori-list', 'index')->name('kategori-list');
        Route::get('/kategori-all', 'allKategori')->name('kategori-all');
        Route::post('/kategori-add', 'store')->name('kategori-add');
        Route::post('/kategori-delete', 'remove')->name('kategori-delete');
    });
    //--use jwt--
});



Route::controller(ProductController::class)->group(function(){
    Route::get('/product-byid/{id}', 'detail')->name('product-detail'); 
    // Route::get('/product-byid-input', 'detailRequestId')->name('product-detail-input'); 
    Route::post('porudct-detailById','detailRequestId')->name('porudct-detailById');
    Route::get('/product-list', 'index')->name('product-list'); 
    Route::get('/product-all','getAllProductController')->name('product-all');
    Route::post('/product-add', 'store')->name('product-add');
    Route::post('/product-delete', 'remove')->name('product-delete');

    Route::post('/product-jual-byid-product','getProductJualByIdProduct')->name('product-jual-byid-product');
    Route::get('/product-jualById/{id}','detailProductJual')->name('product-jual-detail');
    Route::post('/product-jual-save','save_price_sell_product')->name('product-jual-save');
    Route::post('/product-jual-delete','remove_price_sell_product')->name('product-jual-remove');
    
});

Route::controller(UserController::class)->group(function(){
    Route::post('/user-add','store');
    Route::get('/user-list','index');
    Route::get('/user-byid/{id}','detail');
    Route::post('/user-delete','remove');
});

Route::controller(RoleController::class)->group(function(){
    Route::post('/role-add','store');
    Route::get('/role-list','index');
    Route::get('/role-byid/{id}','detail');
    Route::post('/role-delete','remove');
});