<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\PaymeTransactionController;
use \App\Http\Controllers\ExerciseController;
use \App\Http\Controllers\QuestionController;
use \App\Http\Controllers\QuestionAnswerController;
use \App\Http\Controllers\QuestionAnswerLikeController;
use \App\Http\Controllers\UserSkillController;
use \App\Http\Controllers\WorkStudyBackgroundController;

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

        Route::apiResource('skills', UserSkillController::class);

        Route::post("/verify", "\App\Helpers\UserHelper@verifyUser")->name("verification");

        Route::apiResource("work-study", WorkStudyBackgroundController::class);

        Route::apiResource("users", UserController::class);

        Route::apiResource("exercises", ExerciseController::class);

        Route::post("users/avatar", '\App\Helpers\S3Helper@uploadAvatar')->name("user-upload");

        Route::apiResource("questions", QuestionController::class);

        Route::apiResource("question-answers", QuestionAnswerController::class);

        Route::apiResource("question-answer-likes", QuestionAnswerLikeController::class);

        Route::get('s3/get-url', "\App\Helpers\S3Helper@getSignedUrl");
    });

    Route::apiResource("payme", PaymeTransactionController::class);

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
