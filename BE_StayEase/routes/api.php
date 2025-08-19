<?php

use App\Http\Controllers\Admin\DanhMucController;
use App\Http\Controllers\Admin\HinhAnhPhongController;
use App\Http\Controllers\Admin\HopdongController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\MapController;
use App\Http\Controllers\Admin\PhongTroController;
use App\Http\Controllers\Admin\QuyenController;
use App\Http\Controllers\Admin\RegisterController;
use App\Http\Controllers\Admin\ThietBiController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\YeuThichController;
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
    //register
    Route::post('/register',[RegisterController::class, 'store']);
    //Login
    Route::post('/login',[LoginController::class, 'store']);
    //user
    Route::prefix('user')->group(function (){
        Route::get('/',[UserController::class, 'index']);
        Route::post('/',[UserController::class, 'store']);
        Route::put('/{id}',[UserController::class, 'update']);
        Route::delete('/{id}',[UserController::class, 'destroy']);
    });

    //danh muc
    Route::prefix('danhmuc')->group(function (){
        Route::get('/', [DanhMucController::class, 'index']);
        Route::post('/', [DanhMucController::class, 'store']);
        Route::put('/{id}',[DanhMucController::class, 'update']);
        Route::delete('/{id}',[DanhMucController::class, 'destroy']);
    });

    //quyen
    Route::prefix('quyen')->group(function (){
        Route::get('/', [QuyenController::class, 'index']);
        Route::post('/', [QuyenController::class, 'store']);
        Route::put('/{id}', [QuyenController::class, 'update']);
        Route::delete('/{id}', [QuyenController::class, 'destroy']);
    });
    //phongtro
    Route::prefix('phongtro')->group(function (){
        Route::get('/', [PhongTroController::class, 'index']);
        Route::post('/', [PhongTroController::class, 'store']);
        Route::put('/{id}', [PhongTroController::class, 'updatePhongTro']);
        Route::delete('/{id}', [PhongTroController::class, 'destroy']);
    });

    //hinh_anh_phong
    Route::prefix('hinhanh')->group(function (){
        Route::get('/', [HinhAnhPhongController::class, 'index']);
        Route::post('/', [HinhAnhPhongController::class, 'store']);
        Route::put('/{id}', [HinhAnhPhongController::class, 'update']);
        Route::delete('/{id}', [HinhAnhPhongController::class, 'destroy']);
    });

    //thietbi
    Route::prefix('thietbi')->group(function (){
        Route::get('/', [ThietBiController::class, 'index']);
        Route::post('/', [ThietBiController::class, 'store']);
        Route::put('/{id}', [ThietBiController::class, 'update']);
        Route::delete('/{id}', [ThietBiController::class, 'destroy']);
    });

    //yeuthich
    Route::prefix('yeuthich')->group(function (){
        Route::get('/', [YeuThichController::class, 'index']);
        Route::delete('/{id}', [YeuThichController::class, 'destroy']);
    });

    //hopdong
    Route::prefix('hopdong')->group(function (){
        Route::get('/', [HopdongController::class, 'index']);
        Route::post('/', [HopdongController::class, 'create']);
        Route::put('/{ma_hop_dong}', [HopdongController::class, 'update']);
        Route::delete('/{ma_hop_dong}', [HopdongController::class, 'destroy']);
    });

    //map
    Route::prefix('map')->group(function (){
        Route::get('/', [MapController::class, 'index']);
        Route::post('/', [MapController::class, 'store']);
        Route::put('/{id}', [MapController::class, 'update']);
        Route::delete('/{id}', [MapController::class, 'destroy']);
    });
});


