<?php
use App\Http\Controllers\Admin\ModuleGeneratorController;
use Illuminate\Support\Facades\Route;

Route::group([
    "prefix" => "module-create",
    "as" => "module-create.",
    "controller" => ModuleGeneratorController::class
], function () {
    Route::get('/step1', 'getStep1')->name('step1');
    Route::post('/step1', 'postStep1')->name('step1');
    Route::get('/step2', 'getStep2')->name('step2');
    Route::post('/step2', 'postStep2')->name('step2');
    Route::get('/step3', 'getStep3')->name('step3');
    Route::post('/step3', 'postStep3')->name('step3');
    Route::get('/step4', 'getStep4')->name('step4');
    Route::post('/step4', 'postStep4')->name('step4');
});
