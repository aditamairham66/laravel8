<?php

use App\Http\Controllers\Admin\Auth\ForgotController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\LockscreenController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Middleware\Admin\AuthenticationMiddleware;
use App\Http\Middleware\Admin\NonAuthenticationMiddleware;
use Illuminate\Support\Facades\Route;

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

Route::middleware([
    AuthenticationMiddleware::class
])->group(function () {
    Route::get('/', [DashboardController::class, 'getIndex']);
    routeController('/profile', 'Admin\ProfileController');
    routeController('/privileges', 'Admin\PrivilegesController');
    routeController('/notifications', 'Admin\CmsNotificationController');
});

Route::middleware([
    NonAuthenticationMiddleware::class
])->group(function () {
    Route::get('/login', [LoginController::class, 'getIndex']);
    Route::post('/login', [LoginController::class, 'postLogin'])->name('admin.login');
    Route::get('/logout', [LoginController::class, 'getLogout'])->name('admin.logout');

    Route::get('/forgot', [ForgotController::class, 'getIndex']);
    Route::post('/forgot', [ForgotController::class, 'postForgot'])->name('admin.forgot');

    Route::get('/lockscreen', [LockscreenController::class, 'getIndex']);
    Route::post('/lockscreen', [LockscreenController::class, 'postLockscreen'])->name('admin.lockscreen');
    Route::get('/lock-account', [LockscreenController::class, 'getLockUser'])->name('admin.lockuser');
});
