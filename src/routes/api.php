<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\SignatureRequestController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('login',  'login')->name(AuthController::API_LOGIN_NAME);
    Route::post('register', 'register')->name(AuthController::API_REGISTRATION_NAME);
});

Route::middleware('auth:api')->group(function () {

    Route::controller(DocumentController::class)->prefix('document')->group(function () {
        Route::post('/', 'upload');
        Route::post('/sign','signDocument');
    });

    Route::controller(SignatureRequestController::class)->prefix('signature-requests')->group(function () {
        Route::post('/', 'send');
        Route::get('/', 'index');
        Route::patch('/{signatureRequest}', 'updateStatus');
    });
});
