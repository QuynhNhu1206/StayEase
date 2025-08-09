<?php

use App\Http\Controllers\Admin\DanhMucController;
use App\Http\Controllers\Admin\PhongTroController;
use App\Http\Controllers\Admin\QuyenController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('admin')->group(function (){
    //user
    Route::prefix('user')->group(function (){
        Route::get('/',[UserController::class, 'index']);
        Route::post('/',[UserController::class, 'store']);
    });

    //danh muc
    Route::prefix('danhmuc')->group(function (){
        Route::get('/', [DanhMucController::class, 'index']);
        Route::post('/', [DanhMucController::class, 'store']);
    });

    //quyen
    Route::prefix('quyen')->group(function (){
        Route::get('/', [QuyenController::class, 'index']);
        Route::post('/', [QuyenController::class, 'store']);
    });

    //phongtro
    Route::prefix('phongtro')->group(function (){
        Route::get('/', [PhongTroController::class, 'index']);
    Route::post('/', [PhongTroController::class, 'store']);
    });

});


