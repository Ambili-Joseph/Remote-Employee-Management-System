<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

use App\Http\Controllers\Web\EmployeeWebController;
use App\Http\Controllers\Web\DepartmentWebController;


use App\Http\Controllers\Api\EmployeeController;

Route::view('/dashboard', 'dashboard.home')->name('dashboard.home');


Route::prefix('employees')->name('employees.web.')->group(function () {
    Route::get('/', [EmployeeWebController::class, 'index'])->name('index');
    Route::get('/create', [EmployeeWebController::class, 'create'])->name('create');
    Route::post('/', [EmployeeWebController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [EmployeeWebController::class, 'edit'])->name('edit');
    Route::put('/{id}', [EmployeeWebController::class, 'update'])->name('update');
    Route::delete('/{id}', [EmployeeWebController::class, 'destroy'])->name('destroy');
});
Route::prefix('departments')->name('departments.web.')->group(function () {
    Route::get('/', [DepartmentWebController::class, 'index'])->name('index');
    Route::get('/create', [DepartmentWebController::class, 'create'])->name('create');
    Route::post('/', [DepartmentWebController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [DepartmentWebController::class, 'edit'])->name('edit');
    Route::put('/{id}', [DepartmentWebController::class, 'update'])->name('update');
    Route::delete('/{id}', [DepartmentWebController::class, 'destroy'])->name('destroy');
});
Route::post('employees/import', [EmployeeController::class, 'import'])->name('employees.web.import');
Route::get('employees/export', [EmployeeController::class, 'export'])->name('employees.web.export');


