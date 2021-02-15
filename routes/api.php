<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\PaymeTransactionController;
use \App\Http\Controllers\ExerciseController;

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

Route::prefix("v1")->group(function (){

    Route::post("/register", "\App\Helpers\UserHelper@signUpUser")->name("sign_up");
    Route::post("/login", "\App\Helpers\UserHelper@signInUser")->name("sing_in");

    Route::group(["middleware"=>["auth:api"]], function (){

        Route::post("/verify", "\App\Helpers\UserHelper@verifyUser")->name("verification");

        Route::apiResource("users", UserController::class);

        Route::apiResource("exercises", ExerciseController::class);

        Route::post("users/avatar", '\App\Helpers\S3Helper@uploadAvatar')->name("user-upload");
    });

    Route::apiResource("payme", PaymeTransactionController::class);

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
