<?php

use App\Http\Controllers\CustomerController;
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

Route::get('/', function () {
    return view('home');
})->name('home');

// route for get data
Route::get('vehicles/', [VehicleController::class, 'getVehicleByCustomer'])->name('vehicles');

// route resource
Route::resource('customer', CustomerController::class);
Route::resource('vehicle', VehicleController::class);
Route::resource('mechanic', MechanicsController::class);
Route::resource('part', PartController::class);
Route::resource('repair', RepairController::class);
Route::resource('payment', PaymentController::class);
