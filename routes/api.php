<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\FarmController;
use App\Http\Controllers\API\GradeController;
use App\Http\Controllers\API\TurbineController;
use App\Http\Controllers\API\ComponentController;
use App\Http\Controllers\API\InspectionController;

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
    Route::get("/{farm}/turbines", [FarmController::class, 'farmTurbines']);
});

Route::prefix("turbines")->group(function () {
    Route::post("/", [TurbineController::class, 'store']);
    Route::put("/{turbine}", [TurbineController::class, 'update']);
    Route::patch("/{turbine}", [TurbineController::class, 'edit']);
    Route::delete("/{turbine}", [TurbineController::class, 'delete']);
    Route::get("/", [TurbineController::class, 'allTurbines']);
    Route::get("/{turbine}", [TurbineController::class, 'show']);
    Route::get("/{turbine}/inspections", [TurbineController::class, 'turbineInspections']);
    Route::get("/{turbine}/inspections/{inspection}", [TurbineController::class, 'turbineInspection']);
});

Route::prefix("components")->group(function () {
    Route::post("/", [ComponentController::class, 'store']);
    Route::put("/{component}", [ComponentController::class, 'update']);
    Route::patch("/{component}", [ComponentController::class, 'edit']);
    Route::delete("/{component}", [ComponentController::class, 'delete']);
    Route::get("/", [ComponentController::class, 'allComponents']);
    Route::get("/{component}", [ComponentController::class, 'show']);
});

Route::prefix("grades")->group(function () {
    Route::post("/", [GradeController::class, 'store']);
    Route::put("/{grade}", [GradeController::class, 'update']);
    Route::patch("/{grade}", [GradeController::class, 'edit']);
    Route::delete("/{grade}", [GradeController::class, 'delete']);
    Route::get("/", [GradeController::class, 'allGrades']);
    Route::get("/{grade}", [GradeController::class, 'show']);
});

Route::prefix("inspections")->group(function () {
    Route::post("/", [InspectionController::class, 'store']);
    Route::put("/{inspection}", [InspectionController::class, 'update']);
    Route::patch("/{inspection}", [InspectionController::class, 'edit']);
    Route::delete("/{inspection}", [InspectionController::class, 'delete']);
    Route::get("/", [InspectionController::class, 'allInspections']);
    Route::get("/{inspection}", [InspectionController::class, 'show']);
});