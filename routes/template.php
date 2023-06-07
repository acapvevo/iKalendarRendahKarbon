<?php

use Illuminate\Support\Facades\Route;

Route::prefix('template')->name('template.')->group(function () {
    Route::get('', fn () => view('template.index'));
    Route::get('/index', fn () => view('template.index'))->name('index');

    Route::prefix('dashboards')->name('dashboards.')->group(function () {
        Route::get('/defaults', fn () => view('template.dashboards.defaults'))->name('defaults');
        Route::get('/multiporpose', fn () => view('template.dashboards.multiporpose'))->name('multiporpose');
        Route::get('/affiliate', fn () => view('template.dashboards.affiliate'))->name('affiliate');
    });

    Route::prefix('pages')->name('pages.')->group(function () {
        Route::prefix('accounts')->name('accounts.')->group(function () {
            Route::get('/profile', fn () => view('template.pages.accounts.profile'))->name('profile');
            Route::get('/billing', fn () => view('template.pages.accounts.billing'))->name('billing');
            Route::get('/security', fn () => view('template.pages.accounts.security'))->name('security');
            Route::get('/notifications', fn () => view('template.pages.accounts.notifications'))->name('notifications');
        });

        Route::prefix('authentication')->name('authentication.')->group(function () {
            Route::prefix('basic')->name('basic.')->group(function () {
                Route::get('/login', fn () => view('template.pages.authentication.basic.login'))->name('login');
                Route::get('/register', fn () => view('template.pages.authentication.basic.register'))->name('register');
                Route::get('/forgot_password', fn () => view('template.pages.authentication.basic.forgot_password'))->name('forgot_password');
            });

            Route::prefix('social')->name('social.')->group(function () {
                Route::get('/login', fn () => view('template.pages.authentication.social.login'))->name('login');
                Route::get('/register', fn () => view('template.pages.authentication.social.register'))->name('register');
                Route::get('/forgot_password', fn () => view('template.pages.authentication.social.forgot_password'))->name('forgot_password');
            });
        });

        Route::prefix('error')->name('error.')->group(function () {
            Route::get('/400', fn () => view('template.pages.error.400'))->name('400');
            Route::get('/401', fn () => view('template.pages.error.401'))->name('401');
            Route::get('/403', fn () => view('template.pages.error.403'))->name('403');
            Route::get('/404v1', fn () => view('template.pages.error.404v1'))->name('404v1');
            Route::get('/404v2', fn () => view('template.pages.error.404v2'))->name('404v2');
            Route::get('/500', fn () => view('template.pages.error.500'))->name('500');
            Route::get('/503', fn () => view('template.pages.error.503'))->name('503');
            Route::get('/504', fn () => view('template.pages.error.504'))->name('504');
        });

        Route::get('/pricing', fn () => view('template.pages.pricing'))->name('pricing');
        Route::get('/invoice', fn () => view('template.pages.invoice'))->name('invoice');
    });

    Route::prefix('applications')->name('applications.')->group(function () {
        Route::prefix('knowledge_base')->name('knowledge_base.')->group(function () {
            Route::get('/home1', fn () => view('template.applications.knowledge_base.home1'))->name('home1');
            Route::get('/home2', fn () => view('template.applications.knowledge_base.home2'))->name('home2');
            Route::get('/category', fn () => view('template.applications.knowledge_base.category'))->name('category');
            Route::get('/article', fn () => view('template.applications.knowledge_base.article'))->name('article');
        });

        Route::prefix('user_management')->name('user_management.')->group(function () {
            Route::get('/list', fn () => view('template.applications.user_management.list'))->name('list');
            Route::get('/edit', fn () => view('template.applications.user_management.edit'))->name('edit');
            Route::get('/add', fn () => view('template.applications.user_management.add'))->name('add');
            Route::get('/groups_list', fn () => view('template.applications.user_management.groups_list'))->name('groups_list');
            Route::get('/organization_details', fn () => view('template.applications.user_management.organization_details'))->name('organization_details');
        });

        Route::prefix('posts_management')->name('posts_management.')->group(function () {
            Route::get('/list', fn () => view('template.applications.posts_management.list'))->name('list');
            Route::get('/create', fn () => view('template.applications.posts_management.create'))->name('create');
            Route::get('/edit', fn () => view('template.applications.posts_management.edit'))->name('edit');
            Route::get('/admins', fn () => view('template.applications.posts_management.admins'))->name('admins');
        });
    });

    Route::prefix('flows')->name('flows.')->group(function () {
        Route::prefix('multitenants_registration')->name('multitenants_registration.')->group(function () {
            Route::get('/select', fn () => view('template.flows.multitenants_registration.select'))->name('select');
            Route::get('/create', fn () => view('template.flows.multitenants_registration.create'))->name('create');
            Route::get('/add', fn () => view('template.flows.multitenants_registration.add'))->name('add');
            Route::get('/join', fn () => view('template.flows.multitenants_registration.join'))->name('join');
        });
        Route::get('/wizard', fn () => view('template.flows.wizard'))->name('wizard');
    });

    Route::prefix('layout')->name('layout.')->group(function () {
        Route::prefix('navigation')->name('navigation.')->group(function () {
            Route::get('/static', fn () => view('template.layout.navigation.static'))->name('static');
            Route::get('/dark', fn () => view('template.layout.navigation.dark'))->name('dark');
            Route::get('/rtl', fn () => view('template.layout.navigation.rtl'))->name('rtl');
        });

        Route::prefix('container_options')->name('container_options.')->group(function () {
            Route::get('/boxed', fn () => view('template.layout.container_options.boxed'))->name('boxed');
            Route::get('/fluid', fn () => view('template.layout.container_options.fluid'))->name('fluid');
        });

        Route::prefix('page_headers')->name('page_headers.')->group(function () {
            Route::get('/simplified', fn () => view('template.layout.page_headers.simplified'))->name('simplified');
            Route::get('/compact', fn () => view('template.layout.page_headers.compact'))->name('compact');
            Route::get('/content_overlap', fn () => view('template.layout.page_headers.content_overlap'))->name('content_overlap');
            Route::get('/breadcrumbs', fn () => view('template.layout.page_headers.breadcrumbs'))->name('breadcrumbs');
            Route::get('/light', fn () => view('template.layout.page_headers.light'))->name('light');
        });

        Route::prefix('stater')->name('stater.')->group(function () {
            Route::get('/default', fn () => view('template.layout.stater.default'))->name('default');
            Route::get('/minimal', fn () => view('template.layout.stater.minimal'))->name('minimal');
        });
    });

    Route::prefix('components')->name('components.')->group(function () {
        Route::get('/alerts', fn () => view('template.components.alerts'))->name('alerts');
        Route::get('/avatars', fn () => view('template.components.avatars'))->name('avatars');
        Route::get('/badges', fn () => view('template.components.badges'))->name('badges');
        Route::get('/buttons', fn () => view('template.components.buttons'))->name('buttons');
        Route::get('/cards', fn () => view('template.components.cards'))->name('cards');
        Route::get('/dropdowns', fn () => view('template.components.dropdowns'))->name('dropdowns');
        Route::get('/forms', fn () => view('template.components.forms'))->name('forms');
        Route::get('/modals', fn () => view('template.components.modals'))->name('modals');
        Route::get('/navigation', fn () => view('template.components.navigation'))->name('navigation');
        Route::get('/progress', fn () => view('template.components.progress'))->name('progress');
        Route::get('/step', fn () => view('template.components.step'))->name('step');
        Route::get('/timeline', fn () => view('template.components.timeline'))->name('timeline');
        Route::get('/toasts', fn () => view('template.components.toasts'))->name('toasts');
        Route::get('/tooltips', fn () => view('template.components.tooltips'))->name('tooltips');
    });

    Route::prefix('utilities')->name('utilities.')->group(function () {
        Route::get('/animations', fn () => view('template.utilities.animations'))->name('animations');
        Route::get('/background', fn () => view('template.utilities.background'))->name('background');
        Route::get('/borders', fn () => view('template.utilities.borders'))->name('borders');
        Route::get('/lift', fn () => view('template.utilities.lift'))->name('lift');
        Route::get('/shadows', fn () => view('template.utilities.shadows'))->name('shadows');
        Route::get('/typography', fn () => view('template.utilities.typography'))->name('typography');
    });

    Route::get('/charts', fn () => view('template.charts'))->name('charts');
    Route::get('/tables', fn () => view('template.tables'))->name('tables');
});
