<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\SignatureRequestController;
use Illuminate\Routing\Route;

Route::group(['prefix' => 'api'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthController::class, 'login'])
            ->name(AuthController::API_LOGIN_NAME);
        Route::post('register', [AuthController::class, 'register'])
            ->name(AuthController::API_REGISTRATION_NAME);
    });

    Route::middleware('auth:api')->group(function () {

        Route::group([
            'prefix' => 'document'
        ], function () {
            Route::post('/', [DocumentController::class, 'upload']);
            Route::post('/sign', [DocumentController::class, 'signDocument']);
        });

        Route::group([
            'prefix' => 'signature-requests'
        ], function () {
            Route::post('/', [SignatureRequestController::class, 'send']);
            Route::get('/', [SignatureRequestController::class, 'index']);
            Route::patch('/{signatureRequest}', [SignatureRequestController::class, 'updateStatus']);
        });
    });
});
