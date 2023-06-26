<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\PostController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/get',[PostController::class,'index']);
    Route::get('/get/{id}',[PostController::class,'show']);
    Route::get('/get2/{id}',[PostController::class,'show2']);

    Route::get('/logout',[AuthenticationController::class,'logout']);
    Route::get('/me',[AuthenticationController::class,'me']);

    Route::post('/post',[PostController::class,'store']);
    Route::put('/post/{id}',[PostController::class,'update'])->middleware('pemilik-postingan');
    Route::delete('/post/{id}',[PostController::class,'destroy'])->middleware('pemilik-postingan');
});


Route::post('/login',[AuthenticationController::class,'login']);

