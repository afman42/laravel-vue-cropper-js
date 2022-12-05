<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/image-crop',[\App\Http\Controllers\ImageCropperController::class,'index']);
Route::get('/user-show',[\App\Http\Controllers\ImageCropperController::class,'show'])->name('user.show');
Route::post('/user-show/upload',[\App\Http\Controllers\ImageCropperController::class,'update'])->name('user.upload');
