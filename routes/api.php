<?php

use App\Http\Controllers\UserController;
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

Route::post('/register', [UserController::class, 'Register']);
Route::post('/login', [UserController::class, 'login']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', [UserController::class, 'getUser']);
    Route::get('/logout', [UserController::class, 'logout']);
});
