<?php

use illuminate\Support\Facades\Route;
use App\Http\Controllers\csTruckController\truckController;
use App\Http\Controllers\csItemController\itemController;
use App\Http\Controllers\authController\LoginController;
use App\Http\Middleware\RoleMiddleware;

Route::get('/', [LoginController::class, 'showRoleSelection'])->name('select.role');
Route::get('/login/{role}', [LoginController::class, 'loginForm'])->name('login.role');
Route::post('/login', [LoginController::class, 'processLogin'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', RoleMiddleware::class . ':cs'])->group(function () {
    Route::get('/cs-dashboard', [truckController::class, 'dashboard'])->name('cs.dashboard');
    Route::post('/cs-dashboard/truck', [truckController::class, 'createTruck'])->name('cs.addTruck');
    Route::post('/cs-dashboard/truck/{id}/item', [itemController::class, 'addItemToTruck'])->name('cs.addItem');
    Route::delete('/item/{id}', [itemController::class, 'deleteItem'])->name('item.delete');
    Route::delete('/truck/{id}', [truckController::class, 'deleteTruck'])->name('truck.delete');
    Route::put('/item/{id}', [itemController::class, 'editItem'])->name('item.edit');
});

// Route::middleware(['auth', RoleMiddleware::class . ':security'])->group(function () {
//     Route::get('/security-dashboard', [SecurityController::class, 'dashboard'])->name('security.dashboard');
// });

// Route::middleware(['auth', RoleMiddleware::class . ':warehouse'])->group(function () {
//     Route::get('/warehouse-dashboard', [WarehouseController::class, 'dashboard'])->name('warehouse.dashboard');
// });
