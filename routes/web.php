<?php

use Illuminate\Support\Facades\Route;
use PhpParser\Node\Expr\Include_;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

require __DIR__.'/template.php';
require __DIR__.'/super_admin.php';
require __DIR__.'/admin.php';
