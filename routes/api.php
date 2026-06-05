<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DailyReportController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login'])->middleware('throttle:api');

Route::prefix('v1')->middleware(['auth:sanctum', 'active', 'tenant', 'throttle:api'])->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::apiResource('employees', EmployeeController::class)->names('api.employees');
    Route::apiResource('customers', CustomerController::class)->names('api.customers');
    Route::apiResource('tasks', TaskController::class)->names('api.tasks');
    Route::apiResource('reports', DailyReportController::class)->only(['index', 'store'])->names('api.reports');
});

Route::middleware(['auth:sanctum', 'active', 'tenant', 'throttle:api'])->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::apiResource('employees', EmployeeController::class)->names('api.legacy.employees');
    Route::apiResource('customers', CustomerController::class)->names('api.legacy.customers');
    Route::apiResource('tasks', TaskController::class)->names('api.legacy.tasks');
    Route::apiResource('reports', DailyReportController::class)->only(['index', 'store'])->names('api.legacy.reports');
});
