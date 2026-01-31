<?php

use App\Http\Controllers\AssetCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\LocationController;

Route::prefix('v1')->group(function () {
    Route::apiResource('categories', AssetCategoryController::class);
    Route::apiResource('locations', LocationController::class);
    Route::apiResource('assets', AssetController::class);
    Route::get('assets/{asset}/logs', [AssetController::class, 'logs']);
});
