<?php

use illuminate\Support\Facades\Route;
use App\Http\Controllers\csTruckController\truckController;
use App\Http\Controllers\csItemController\itemController;
use App\Http\Controllers\authController\LoginController;
use App\Http\Controllers\WarehouseController\WarehouseController;
use App\Http\Controllers\SecurityController\SecurityController;
use App\Http\Controllers\WarehouseController\MonitorWarehouseController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\AdminUserController;

Route::get('/login', function () {
    return redirect()->route('select.role');
});



Route::prefix('admin')->group(function () {
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.dashboard');
    Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
});


Route::get('/', [LoginController::class, 'showRoleSelection'])->name('select.role');
Route::get('/login/{role}', [LoginController::class, 'loginForm'])->name('login.role');
Route::post('/login', [LoginController::class, 'processLogin'])->name('login');
Route::post('/logout', [LoginController::class, 'logoutUser'])->name('logout');

Route::middleware(['auth', RoleMiddleware::class . ':cs'])->group(function () {
    Route::get('/cs-dashboard', [truckController::class, 'dashboard'])->name('cs.dashboard');
    Route::post('/cs-dashboard/truck', [truckController::class, 'createTruck'])->name('cs.addTruck');
    Route::post('/cs-dashboard/truck/{id}/item', [itemController::class, 'addItemToTruck'])->name('cs.addItem');
    Route::delete('/item/{id}', [itemController::class, 'deleteItem'])->name('item.delete');
    Route::delete('/truck/{id}', [truckController::class, 'deleteTruck'])->name('truck.delete');
    Route::put('/item/{id}', [itemController::class, 'editItem'])->name('item.edit');

    Route::get('/cs/history', [itemController::class, 'history'])->name('cs.history');
    Route::get('/cs/history/pdf', [itemController::class, 'exportHistoryPdf'])->name('cs.history.pdf');
});

Route::middleware(['auth', RoleMiddleware::class . ':security'])->group(function () {
    Route::get('/security-dashboard', [SecurityController::class, 'dashboard'])->name('security.dashboard');
    Route::put('/security-dashboard/truck/{checkId}', [SecurityController::class, 'updateTruckData'])->name('security.updateTruckData');
});

Route::middleware(['auth', RoleMiddleware::class . ':warehouse'])->group(function () {
    Route::get('/warehouse-dashboard', [WarehouseController::class, 'dashboard'])->name('warehouse.dashboard');
    Route::put('/warehouse-dashboard/truck/{check}', [WarehouseController::class, 'updateLoadingStatus'])->name('warehouse.updateLoadingStatus');
    Route::get('/warehouse-dashboard/monitor', [MonitorWarehouseController::class, 'index'])->name('warehouse.monitor');
    Route::get('/warehouse-dashboard/monitor/data', [MonitorWarehouseController::class, 'fetchData'])->name('monitor.warehouse.data');
});
