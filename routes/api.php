<?php

use App\Http\Controllers\Api\GenerateTokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('token')
    ->group(function () {
        Route::get('generate', [GenerateTokenController::class, 'getGenerate']);
        Route::get('update', [GenerateTokenController::class, 'getUpdate']);
    });

/**
 * Route with token
 */
Route::middleware([
    \App\Http\Middleware\Api\NonAuthenticationMiddleware::class,
])->group(function () {
    // your route here

    /**
     * Route with authentication users
     */
    Route::middleware([
        \App\Http\Middleware\Api\AuthenticationMiddleware::class,
    ])->group(function () {
        // your route here

    });
});