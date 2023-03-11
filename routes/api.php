<?php

use App\Http\Controllers\API\KategoriController;
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
    Route::get('/kategori-list', 'index'); 
    Route::post('/kategori-add', 'store');
    Route::post('/kategori-delete', 'remove');
});