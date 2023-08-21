<?php

use App\Http\Controllers\Web\FarmController;
use App\Http\Controllers\Web\InspectionController;
use App\Http\Controllers\Web\TurbineController;
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

Route::get('/', function () {
    return redirect('/farms');
});

Route::prefix('farms')->group(function () {
    Route::get('/', [FarmController::class, 'index']);
    Route::get('/{farm}', [FarmController::class, 'show']);
    Route::get('/{farm}/{turbines}', [FarmController::class, 'farmTurbines']);
});


Route::prefix('turbines')->group(function () {
    Route::get('/{turbine}', [TurbineController::class, 'show']);
    Route::get('/{turbine}/inspections/{inspection}', [TurbineController::class, 'turbineInspection']);
});
