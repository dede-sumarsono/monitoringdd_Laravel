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
    //Route::get('/getalluser',[AuthenticationController::class,'getalluser'])->middleware('pemilik-postingan');
    //mendapatkan user dengan level status 2
    Route::get('/getalluser',[AuthenticationController::class,'getalluser']);
    Route::post('/updatelevel/{id}',[AuthenticationController::class,'updatelevel']);
    Route::post('/deleteuser/{id}',[AuthenticationController::class,'deleteuser']);

    Route::get('/getuserorder/{id}',[PostController::class,'userorder']);
    Route::get('/getuserordercount/{id}',[PostController::class,'userordertotal']);
    Route::get('/getuserordercount2/{id}',[PostController::class,'userordertotal2']);
    Route::get('/jumlahstatuspesanan',[PostController::class,'jumlahstatuspesanan']);
    Route::post('/post',[PostController::class,'store']);
    Route::put('/post/{id}',[PostController::class,'update'])->middleware('pemilik-postingan');
    Route::delete('/post/{id}',[PostController::class,'destroy'])->middleware('pemilik-postingan');
});


Route::post('/login',[AuthenticationController::class,'login']);
Route::post('/register',[AuthenticationController::class,'register']);


