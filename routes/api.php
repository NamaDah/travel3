<?php

use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\MobilController;
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


Route::controller(LoginRegisterController::class)->group(function() {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::controller(MobilController::class)->group(function () {
        Route::get('/mobil', 'index');
        Route::get('/mobil/{id}', 'show');
        Route::get('/mobil/search/{nama_mobil}', 'search');
        Route::post('/mobil', 'store');
        Route::post('/mobil/{id}', 'update');
        Route::get('/mobil/{id}', 'destroy');
    });
});
