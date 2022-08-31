<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\RolePermissionController;
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
    return redirect()->route('dashboard');
});

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('departments/quick-create', [DepartmentController::class, 'quickCreate'])->name('departments.quick-create');
    Route::resource('departments', DepartmentController::class);

    Route::resource('designations', DesignationController::class);

    Route::resource('employees', EmployeeController::class);
    
    Route::resource('holidays', HolidayController::class);

    Route::resource('attendances', AttendanceController::class);

    Route::get('leaves/{leave:id}/approve', [LeaveController::class, 'approve'])->name('leaves.approve');
    Route::get('leaves/{leave:id}/reject', [LeaveController::class, 'reject'])->name('leaves.reject');
    Route::resource('leaves', LeaveController::class);

    Route::resource('roles-permissions', RolePermissionController::class);
});

require __DIR__.'/auth.php';
