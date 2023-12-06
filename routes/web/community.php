<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Community\DashboardController;
use App\Http\Controllers\Community\NewsletterController;
use App\Http\Controllers\Community\Contest\FormController;
use App\Http\Controllers\Community\User\FinanceController;
use App\Http\Controllers\Community\User\PictureController;
use App\Http\Controllers\Community\User\ProfileController;
use App\Http\Controllers\Community\User\SettingController;
use App\Http\Controllers\Community\Auth\NewPasswordController;
use App\Http\Controllers\Community\Auth\VerifyEmailController;
use App\Http\Controllers\Community\Contest\SubmissionController;
use App\Http\Controllers\Community\Auth\RegisteredUserController;
use App\Http\Controllers\Community\Contest\CompetitionController;
use App\Http\Controllers\Community\Auth\PasswordResetLinkController;
use App\Http\Controllers\Community\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Community\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Community\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Community\Auth\EmailVerificationNotificationController;

Route::prefix('community')->name('community.')->group(function () {

    Route::middleware('guest:community')->group(function () {

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

        // Form routes
        Route::prefix('form')->name('form.')->group(function () {
            Route::get('', [FormController::class, 'view'])->name('view');
            Route::get('/success', [FormController::class, 'success'])->name('success');
        });
    });

    Route::middleware('auth:community')->group(function () {

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
                Route::post('/ic', [ProfileController::class, 'ic'])->name('ic');
            });

            //Finance
            Route::prefix('finance')->name('finance.')->group(function () {
                Route::get('', [FinanceController::class, 'view'])->name('view');
                Route::post('/statement', [FinanceController::class, 'statement'])->name('statement');
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

        // Contest Management routes
        Route::prefix('contest')->name('contest.')->group(function () {

            //Competition
            Route::prefix('competition')->name('competition.')->group(function () {
                Route::get('', [CompetitionController::class, 'list'])->name('list');
            });

            //Submission
            Route::prefix('submission')->name('submission.')->group(function () {
                Route::match(['get', 'post'], '/category', [SubmissionController::class, 'category'])->name('category');
                Route::match(['get', 'post'], '', [SubmissionController::class, 'list'])->name('list');
                Route::match(['get', 'post'], '/download', [SubmissionController::class, 'download'])->name('download');
            });
        });

        // Newsletter Management routes
        Route::prefix('newsletter')->name('newsletter.')->group(function () {
            Route::get('', [NewsletterController::class, 'list'])->name('list');
            Route::get('/thumbnail', [NewsletterController::class, 'thumbnail'])->name('thumbnail');
            Route::get('/{id}', [NewsletterController::class, 'view'])->name('view');
        });
    });
});
