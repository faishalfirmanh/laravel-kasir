<?php

use App\Http\Controllers\API\KategoriController;
use App\Http\Controllers\API\NewStruckController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\KeranjangKasirController;
use App\Http\Controllers\API\ProductBeliController;
use App\Http\Controllers\API\TokoController;
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
    Route::controller(KategoriController::class)->prefix('kategori')->group(function () {
        Route::post('/', 'index')->name('kategori-list');
        Route::get('/kategori-byid/{id}', 'detail')->name('kategori-details-byId'); 
        Route::get('/kategori-detail', 'detail2')->name('kategori-details'); 
        Route::get('/kategori-details-input','detailKategori')->name('kategori-details-input');
        Route::get('/kategori-all', 'allKategori')->name('kategori-all');
        Route::post('/kategori-add', 'store')->name('kategori-add');
        Route::post('/kategori-delete', 'remove')->name('kategori-delete');
    });

    //toko
    Route::controller(TokoController::class)->prefix('toko')->group(function(){
        Route::post('/','getAllTokoPaginateSearchCon')->name('toko-list');//paginate - search
        Route::post('/post-toko','store')->name('post-toko');
        Route::post('/detail-toko','detail')->name('detail-toko');
        Route::post('/get-all-toko','index')->name('get-all-toko');//no paginate
        Route::post('/delete-toko','remove')->name('delete-toko');
    });

    //role
    Route::controller(RoleController::class)->prefix('role')->group(function(){
        Route::get('/','indexGetAllCon')->name('get-all-role');// all data without paging
        Route::post('/role-add','store')->name('role-add');
        Route::get('/role-list','index')->name('role-list'); //paging bawaan laravel
        Route::get('/role-byid/{id}','detail');
        Route::post('/role-detail','detailPost')->name('role-detail');
        Route::post('/role-delete','remove')->name('role-delete');
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
    Route::post('/product-jual-byid','detailProductJual2')->name('product-jual-byid');
    Route::post('/product-jual-save','save_price_sell_product')->name('product-jual-save');
    Route::post('/product-jual-delete','remove_price_sell_product')->name('product-jual-remove');

    Route::post('/product-list-jual-price-set','getAllProductPriceSet')->name('product-list-jual-price-set');
    Route::post('/product-list-jual-price-not-set','getAllProductPriceNotSet')->name('product-list-jual-price-not-set');

    //serach product price
    Route::post('/product-list-jual-price-search','getProdcutPriceSearch')->name('product-list-jual-price-search');
    
});

//Product Beli
Route::controller(ProductBeliController::class)->group(function(){
    Route::post('/get-all-product-beli','getAllProductBeliCon')->name('get-all-product-beli');
    Route::post('/get-product-beliById','getProductBeliConById')->name('get-product-beliById');
    Route::post('/save-product-beli','saveProductBeliCon')->name('save-product-beli');
    Route::post('/delete-product-beli','deleteProductBeliCon')->name('delete-product-beli');
});

 //struct 
Route::controller(NewStruckController::class)->group(function(){
    Route::post('/get-struck-id','getStrudById')->name('get-struck-id');
    Route::post('/generate-new-struck','GenerateNewStruck')->name('generate-new-struck');
    Route::post('/update-data-struck','UpdateStruck')->name('update-data-struck');
    Route::post('/get-view-struck-barang','getProductByIdStruck')->name('get-view-struck-barang');//menampilkan data struck belum bayar ->progres->done
    Route::post('/get-view-strukc-barang-final','UpdateStruck')->name('get-view-strukc-barang-final');//menampilkan data struck sudah  bayar (final) ->progres

    Route::post('/input-price-user-bayar','InputPriceUserBayar')->name('input-price-user-bayar');//ok
    Route::post('/get-keuntungan-by-struck-id', 'getKeuntunganByIdStruckCon')->name('get-keuntungan-by-struck-id');
});

//keranjang
Route::controller(KeranjangKasirController::class)->group(function(){
    Route::post('/get-kerajang-byid','GetKerajangById')->name('get-kerajang-byid');
    Route::post('/kerajang-create','CreateNewKerajangProduct')->name('kerajang-create');
    Route::post('/get-keranjang-product','CreateNewKerajangProduct')->name('get-keranjang-product');
    //meanmpilkan respon tiap2 barang, berisi nama, total barang, total  beli barang ->progres

    //addProductKeranjang+1->ok
    Route::post('/add-keranjang-product-plus1','add1JumlahProductKerajang')->name('add-keranjang-product-plus1');
    //removeProductKeranjang->ok
    Route::post('/remove-keranjang-product-min1','reduce1JumlahProductKerajang')->name('remove-keranjang-product-min1');
    //delete keranjang dan update total struck
    Route::post('/delete-keranjang','deleteKeranjang')->name('delete-keranjang');

});


Route::controller(UserController::class)->group(function(){
    Route::post('/user-add','store');
    Route::post('/user-change-password','changePassword')->name('user-change-password');
    Route::post('/user-detail','detailParam')->name('user-detail');
    Route::get('/user-list','index');
    Route::get('/user-byid/{id}','detail');
    Route::post('/user-delete','remove')->name('user-delete');
});

