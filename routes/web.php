<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnterpriseController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DriverLicenseController;
use App\Http\Controllers\SolicitationController;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\SolicitationPricingController;
use App\Http\Controllers\PricingController;

Route::get('/', function () {
    return view('welcome');
});

// Rotas protegidas por autenticação e verificação
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rotas resource para todas as entidades principais
    Route::resource('enterprises', EnterpriseController::class);
    Route::resource('branches', BranchController::class);
    Route::resource('contracts', ContractController::class);
    Route::resource('drivers', DriverController::class);
    Route::resource('vehicles', VehicleController::class);
    Route::resource('documents', DocumentController::class);
    Route::resource('driver-licenses', DriverLicenseController::class);
    Route::resource('solicitations', SolicitationController::class);
    Route::resource('researches', ResearchController::class);
    Route::resource('solicitation-pricings', SolicitationPricingController::class);
    Route::resource('pricings', PricingController::class);
});
