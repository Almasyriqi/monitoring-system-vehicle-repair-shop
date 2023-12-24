<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MechanicsController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DashboardController::class, 'index'])->name('home');

// route for get data
Route::get('vehicles/', [VehicleController::class, 'getVehicleByCustomer'])->name('vehicles');
Route::get('/getDataStatus', [DashboardController::class, 'getDataStatus'])->name('status.vehicle');
Route::get('/getCompleteRepairs', [DashboardController::class, 'getCompleteRepairs'])->name('complete.repairs');
Route::get('/getAverageTime', [DashboardController::class, 'getAverageTime'])->name('average.time');
Route::get('/getRevenueData', [DashboardController::class, 'getRevenueData'])->name('revenue.data');
Route::get('/getMechanicEfficient', [DashboardController::class, 'getMechanicEfficient'])->name('efficiency.mechanic');

// route resource
Route::resource('customer', CustomerController::class);
Route::resource('vehicle', VehicleController::class);
Route::resource('mechanic', MechanicsController::class);
Route::resource('part', PartController::class);
Route::resource('repair', RepairController::class);
Route::resource('payment', PaymentController::class);
