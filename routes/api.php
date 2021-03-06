<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LatheController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\UserLatheTrackingController;
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
Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::apiResource('/users', UserController::class);
    Route::apiResource('/lathes', LatheController::class);

    Route::post('/tracking/store', UserLatheTrackingController::class.'@store');
    Route::patch('/tracking/update', UserLatheTrackingController::class.'@update');

    Route::get('/tracking/user/{id}', UserLatheTrackingController::class.'@getUserHistory');
    Route::get('/tracking/lathe/{id}', UserLatheTrackingController::class.'@getLatheHistory');

    Route::get('/tracking/user/info/{id}', UserLatheTrackingController::class.'@getUserCurrentInfo');
    Route::get('/tracking/lathe/info/{id}', UserLatheTrackingController::class.'@getLatheCurrentInfo');
});


