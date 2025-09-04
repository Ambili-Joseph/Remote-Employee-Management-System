<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\DepartmentController;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::apiResource('employees', EmployeeController::class);
    Route::post('departments', [App\Http\Controllers\Api\DepartmentController::class, 'store']);

     Route::get('departments', [App\Http\Controllers\Api\DepartmentController::class, 'index']);
    // Route::apiResource('departments', DepartmentController::class);
    

    Route::post('/employees/import', [EmployeeController::class, 'import']);
    Route::get('/employees/export', [EmployeeController::class, 'export']);
});
