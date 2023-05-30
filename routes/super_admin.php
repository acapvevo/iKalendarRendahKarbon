<?php

use App\Http\Controllers\SuperAdmin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\SuperAdmin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\SuperAdmin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\SuperAdmin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\SuperAdmin\Auth\NewPasswordController;
use App\Http\Controllers\SuperAdmin\Auth\PasswordResetLinkController;
use App\Http\Controllers\SuperAdmin\Auth\RegisteredUserController;
use App\Http\Controllers\SuperAdmin\Auth\VerifyEmailController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('super_admin')->name('super_admin.')->group(function () {

    Route::middleware('guest:super_admin')->group(function () {

        Route::get('/register', [RegisteredUserController::class, 'create'])
            ->name('register');

        Route::post('/register', [RegisteredUserController::class, 'store']);

        Route::get('/login', [AuthenticatedSessionController::class, 'create'])
            ->name('login');

        Route::post('/login', [AuthenticatedSessionController::class, 'store']);

        Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
            ->name('password.request');

        Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
            ->name('password.email');

        Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
            ->name('password.reset');

        Route::post('/reset-password', [NewPasswordController::class, 'store'])
            ->name('password.update');
    });

    Route::middleware('auth:super_admin')->group(function () {

        Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
            ->name('verification.notice');

        Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');

        Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware(['throttle:6,1'])
            ->name('verification.send');

        Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
            ->name('password.confirm');

        Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store']);

        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');

        Route::get('/', [DashboardController::class, 'index']);

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');
    });
});
