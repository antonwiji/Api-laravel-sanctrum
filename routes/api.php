<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CvController;
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
// protected Route
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::delete('/cv/{id}', [CvController::class, 'destroy']);
    Route::post('/cv', [CvController::class, 'store']);
    Route::put('/cv/{id}', [CvController::class, 'update']);
    Route::post('/logout', [AuthController::class, 'logout']);

});

// public Route

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/cv', [CvController::class, 'index']);
Route::get('/cv/{id}', [CvController::class, 'show']);

