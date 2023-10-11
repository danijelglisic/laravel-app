<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AddRandomUserController,
    VerifyEmailController,
    ChangePasswordController,
    RegisterController,
    LoginController,
    ForgotPasswordController,
    UserController
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/verify-email', VerifyEmailController::class);
    Route::post('/change-password', ChangePasswordController::class);
    Route::post('/resend-verification-token', [RegisterController::class, 'resendToken'])
        ->middleware('throttle:verification-code');
});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/add-random-user', AddRandomUserController::class);
    Route::apiResource('/users', UserController::class)->only(['index', 'update', 'destroy']);
});

Route::post('/register', [RegisterController::class, 'store']);
Route::post('/login', LoginController::class);
Route::post('/forgot-password', [ForgotPasswordController::class, 'store']);
Route::put('/reset-password/{token}', [ForgotPasswordController::class, 'update']);
