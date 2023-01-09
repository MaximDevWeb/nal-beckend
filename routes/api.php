<?php

use App\Http\Controllers\Api\V1\AuthController;
    use App\Http\Controllers\Api\V1\CategoryController;
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

Route::middleware('guest')->prefix('v1')->group(function () {
    Route::post('/auth/create', [AuthController::class, 'store']);
    Route::post('/auth/login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::get('/auth/user', [AuthController::class, 'user']);
    Route::get('/auth/logout', [AuthController::class, 'logout']);

    Route::apiResource('/auth/article/category', CategoryController::class);
});
