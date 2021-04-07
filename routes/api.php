<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

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

Route::post('upload', [FileController::class, 'upload']);
Route::get('fileslist', [FileController::class, 'filesList']);
Route::post('updatename', [FileController::class, 'updateName']);
Route::post('updatesize', [FileController::class, 'updateSize']);
Route::post('updatefilter', [FileController::class, 'updateFilter']);
Route::post('updatesize', [FileController::class, 'updateSize']);
Route::post('updatecrop', [FileController::class, 'updateCrop']);
Route::get('downloadfile/{fileName}', [FileController::class, 'downloadFile']);
