<?php

use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\PostRegistrationController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use ProtoneMedia\LaravelXssProtection\Middleware\XssCleanInput;

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

Route::group(['middleware' => ['auth:sanctum', XssCleanInput::class]], function () {
    Route::apiResource('/users', UserController::class);
    Route::apiResource('/groups', GroupController::class);
    Route::apiResource('/postregistrations', PostRegistrationController::class);
});

Route::post('/users/register', 'Api\UserController@register')->middleware(XssCleanInput::class);
Route::post('/auth', 'Auth\ApiLoginController@authenticate')->middleware(XssCleanInput::class);


