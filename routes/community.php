<?php

use App\Http\Controllers\Community\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Community\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Community\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Community\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Community\Auth\NewPasswordController;
use App\Http\Controllers\Community\Auth\PasswordResetLinkController;
use App\Http\Controllers\Community\Auth\RegisteredUserController;
use App\Http\Controllers\Community\Auth\VerifyEmailController;
use App\Http\Controllers\Community\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('community')->name('community.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])
        ->middleware('auth:community');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('auth:community')
        ->name('dashboard');

    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->middleware('guest:community')
        ->name('register');

    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware('guest:community');

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->middleware('guest:community')
        ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest:community');

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->middleware('guest:community')
        ->name('password.request');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('guest:community')
        ->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->middleware('guest:community')
        ->name('password.reset');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware('guest:community')
        ->name('password.update');

    Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
        ->middleware('auth:community')
        ->name('verification.notice');

    Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['auth:community', 'signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware(['auth:community', 'throttle:6,1'])
        ->name('verification.send');

    Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->middleware('auth:community')
        ->name('password.confirm');

    Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
        ->middleware('auth:community');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth:community')
        ->name('logout');
});
