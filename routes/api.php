<?php
namespace App\Http\Controllers\Api;

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


Route::post('users', [UserController::class, 'store']);
Route::post('auth', [AuthController::class, 'store']);


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::delete('auth', [AuthController::class, 'destroy']);
    Route::apiResource('users', UserController::class)->except('store');
    Route::apiResource('documents', DocumentController::class);
    Route::apiResource('users.documents', DocumentUserController::class)->only(['index', 'update', 'destroy']);
});
