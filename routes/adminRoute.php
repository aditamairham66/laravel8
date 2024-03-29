<?php

use App\Http\Controllers\Admin\DashboardController;
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

Route::get('/', [DashboardController::class, 'getIndex']);

routeController('/profile', 'Admin\ProfileController');
routeController('/privileges', 'Admin\PrivilegesController');
routeController('/notifications', 'Admin\CmsNotificationController');
