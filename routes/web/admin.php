<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\Analysis\CompetitionController as AnalysisCompetitionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ZoneController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\User\PictureController;
use App\Http\Controllers\Admin\User\ProfileController;
use App\Http\Controllers\Admin\User\SettingController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\Contest\AnalysisController;
use App\Http\Controllers\Admin\Contest\QuestionController;
use App\Http\Controllers\Admin\Contest\SubmissionController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\Contest\CompetitionController;
use App\Http\Controllers\Admin\Participant\CommunityController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest:admin')->group(function () {

        // Route::get('/register', [RegisteredUserController::class, 'create'])
        //     ->name('register');

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

    Route::middleware('auth:admin')->group(function () {

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

        // Participant Management routes
        Route::prefix('participant')->name('participant.')->group(function () {

            //Community
            Route::prefix('community')->name('community.')->group(function () {
                Route::get('', [CommunityController::class, 'list'])->name('list');
                Route::match(['get', 'post'], '/filter', [CommunityController::class, 'filter'])->name('filter');
                Route::post('/ic', [CommunityController::class, 'ic'])->name('ic');
            });
        });

        // Contest Management routes
        Route::prefix('contest')->name('contest.')->group(function () {

            //Competition
            Route::prefix('competition')->name('competition.')->group(function () {
                Route::get('', [CompetitionController::class, 'list'])->name('list');
            });

            //Question
            Route::prefix('question')->name('question.')->group(function () {
                Route::match(['get', 'post'], '', [QuestionController::class, 'list'])->name('list');
            });

            //Submission
            Route::prefix('submission')->name('submission.')->group(function () {
                Route::match(['get', 'post'], '', [SubmissionController::class, 'list'])->name('list');
                Route::match(['get', 'post'], '/filter', [SubmissionController::class, 'filter'])->name('filter');
                Route::match(['get', 'post'], '/view', [SubmissionController::class, 'view'])->name('view');
                Route::match(['get', 'post'], '/download', [SubmissionController::class, 'download'])->name('download');
            });
        });

        //Analysis
        Route::prefix('analysis')->name('analysis.')->group(function () {
            Route::prefix('competition')->name('competition.')->group(function () {
                Route::match(['get', 'post'], '', [AnalysisCompetitionController::class, 'view'])->name('view');
            });
        });

        // Activity Management routes
        Route::prefix('activity')->name('activity.')->group(function () {
            Route::get('', [ActivityController::class, 'list'])->name('list');
        });

        // Zone Management routes
        Route::prefix('zone')->name('zone.')->group(function () {
            Route::get('', [ZoneController::class, 'list'])->name('list');
        });

        // Newsletter Management routes
        Route::prefix('newsletter')->name('newsletter.')->group(function () {
            Route::get('', [NewsletterController::class, 'list'])->name('list');
            Route::get('/thumbnail', [NewsletterController::class, 'thumbnail'])->name('thumbnail');
        });
    });
});
