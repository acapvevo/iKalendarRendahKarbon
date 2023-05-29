<?php

use App\Http\Controllers\TemplateController;
use Illuminate\Support\Facades\Route;

Route::prefix('template')->name('template.')->group(function () {
    Route::get('', [TemplateController::class, 'index']);
    Route::get('/index', [TemplateController::class, 'index'])->name('index');
    Route::get('/docs', [TemplateController::class, 'docs'])->name('docs');
    Route::get('/orders', [TemplateController::class, 'orders'])->name('orders');

    Route::prefix('pages')->name('pages.')->group(function () {
        Route::get('/notifications', [TemplateController::class, 'notifications'])->name('notifications');
        Route::get('/account', [TemplateController::class, 'account'])->name('account');
        Route::get('/settings', [TemplateController::class, 'settings'])->name('settings');
    });

    Route::prefix('external')->name('external.')->group(function () {
        Route::get('/login', [TemplateController::class, 'login'])->name('login');
        Route::get('/register', [TemplateController::class, 'register'])->name('register');
        Route::get('/reset_password', [TemplateController::class, 'reset_password'])->name('reset_password');
        Route::get('/page404', [TemplateController::class, 'page404'])->name('page404');
    });

    Route::get('/charts', [TemplateController::class, 'charts'])->name('charts');
    Route::get('/help', [TemplateController::class, 'help'])->name('help');
});
