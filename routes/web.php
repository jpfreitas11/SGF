<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PositionChangeRequestController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\SalaryChangeRequestController;
use App\Http\Controllers\TransferRequestController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::resource('departments', DepartmentController::class)
        ->only(['index', 'create', 'store']);

    Route::resource('positions', PositionController::class)
        ->only(['index', 'create', 'store']);

    Route::resource('employees', EmployeeController::class)
        ->only(['index', 'create', 'store', 'destroy']);

    Route::get('/transfers', [TransferRequestController::class, 'index'])
        ->name('transfers.index');
    Route::post('/employees/{employee}/transfers', [TransferRequestController::class, 'store'])
        ->name('transfers.store');
    Route::post('/transfers/{transferRequest}/approve', [TransferRequestController::class, 'approve'])
        ->name('transfers.approve');
    Route::post('/transfers/{transferRequest}/reject', [TransferRequestController::class, 'reject'])
        ->name('transfers.reject');

    Route::get('/salary-changes', [SalaryChangeRequestController::class, 'index'])
        ->name('salary-changes.index');
    Route::post('/employees/{employee}/salary-changes', [SalaryChangeRequestController::class, 'store'])
        ->name('salary-changes.store');
    Route::post('/salary-changes/{salaryChangeRequest}/approve', [SalaryChangeRequestController::class, 'approve'])
        ->name('salary-changes.approve');
    Route::post('/salary-changes/{salaryChangeRequest}/reject', [SalaryChangeRequestController::class, 'reject'])
        ->name('salary-changes.reject');

    Route::get('/position-changes', [PositionChangeRequestController::class, 'index'])
        ->name('position-changes.index');
    Route::post('/employees/{employee}/position-changes', [PositionChangeRequestController::class, 'store'])
        ->name('position-changes.store');
    Route::post('/position-changes/{positionChangeRequest}/approve', [PositionChangeRequestController::class, 'approve'])
        ->name('position-changes.approve');
    Route::post('/position-changes/{positionChangeRequest}/reject', [PositionChangeRequestController::class, 'reject'])
        ->name('position-changes.reject');

    Route::get('/employees/{employee}/history', [EmployeeController::class, 'history'])
    ->name('employees.history');
});

require __DIR__.'/settings.php';