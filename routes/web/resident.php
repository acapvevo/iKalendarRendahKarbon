<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Resident\DashboardController;
use App\Http\Controllers\Resident\User\PictureController;
use App\Http\Controllers\Resident\User\ProfileController;
use App\Http\Controllers\Resident\User\SettingController;
use App\Http\Controllers\Resident\Auth\NewPasswordController;
use App\Http\Controllers\Resident\Auth\VerifyEmailController;
use App\Http\Controllers\Resident\Auth\RegisteredUserController;
use App\Http\Controllers\Resident\Auth\PasswordResetLinkController;
use App\Http\Controllers\Resident\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Resident\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Resident\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Resident\Auth\EmailVerificationNotificationController;

Route::prefix('resident')->name('resident.')->group(function () {

    Route::middleware('guest:resident')->group(function () {

        Route::get('/register', [RegisteredUserController::class, 'create'])
            ->name('register');

        // Route::post('/register', [RegisteredUserController::class, 'store']);

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

    Route::middleware('auth:resident')->group(function () {

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

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Dashboard routes
        Route::prefix('dashboard')->name('dashboard.')->group(function () {

            Route::get('', [DashboardController::class, 'index'])
                ->name('view');
        });

        // User Management routes
        Route::prefix('user')->name('user.')->group(function () {

            //Profile
            Route::prefix('profile')->name('profile.')->group(function () {
                Route::get('', [ProfileController::class, 'view'])->name('view');
            });

            //Setting
            Route::prefix('setting')->name('setting.')->group(function () {
                Route::get('', [SettingController::class, 'view'])->name('view');
            });

            //Profile Picture
            Route::prefix('picture')->name('picture.')->group(function () {
                Route::get('', [PictureController::class, 'show'])->name('show');
            });
        });
    });
});
