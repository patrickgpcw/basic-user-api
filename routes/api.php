<?php

use App\Http\Controllers\API\LoginApiController;
use App\Http\Controllers\API\UserApiController;
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

Route::post('/login', [LoginApiController::class, 'login']);

Route::post('/usuario', [UserApiController::class, 'create']);

Route::middleware('jwt')->group(function () {
    Route::get('/usuario', [UserApiController::class, 'read']);
    Route::get('/usuario/{user}', [UserApiController::class, 'show']);
    Route::put('/usuario/{user}', [UserApiController::class, 'update']);
    Route::delete('/usuario/{user}', [UserApiController::class, 'delete']);
});
