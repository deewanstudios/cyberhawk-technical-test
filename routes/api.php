<?php

use App\Http\Controllers\ComponentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FarmController;
use App\Http\Controllers\TurbineController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix("farms")->group(function () {
    Route::post("/", [FarmController::class, 'store']);
    Route::get("/", [FarmController::class, 'index']);
    Route::get("/{farm}", [FarmController::class, 'show']);
    Route::put("/{farm}", [FarmController::class, 'update']);
    Route::patch("/{farm}", [FarmController::class, 'edit']);
    Route::delete("/{farm}", [FarmController::class, 'delete']);
});

Route::prefix("turbines")->group(function () {
    Route::post("/", [TurbineController::class, 'store']);
    Route::put("/{turbine}", [TurbineController::class, 'update']);
    Route::patch("/{turbine}", [TurbineController::class, 'edit']);
    Route::delete("/{turbine}", [TurbineController::class, 'delete']);
    Route::get("/", [TurbineController::class, 'allTurbines']);
    Route::get("/{turbine}", [TurbineController::class, 'show']);
});

Route::prefix("components")->group(function () {
    Route::post("/", [ComponentController::class, 'store']);
    Route::put("/{component}", [ComponentController::class, 'update']);
    Route::patch("/{component}", [ComponentController::class, 'edit']);
    Route::delete("/{component}", [ComponentController::class, 'delete']);
    Route::get("/", [ComponentController::class, 'allComponents']);
    Route::get("/{component}", [ComponentController::class, 'show']);
});
