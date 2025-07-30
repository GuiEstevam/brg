<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnterpriseController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DriverLicenseController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SolicitationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SolicitationPricingController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ROTAS SÓ PARA SUPERADMIN
    Route::middleware(['role:superadmin'])->group(function () {
        Route::resource('enterprises', EnterpriseController::class);
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        // Rotas extras para gerenciamento de usuários/papéis
        Route::get('roles/{role}/attach-user', [RoleController::class, 'attachUserForm'])->name('roles.attach-user');
        Route::post('roles/{role}/attach-user', [RoleController::class, 'attachUser'])->name('roles.attach-user.submit');
        Route::delete('roles/{role}/detach-user/{user}', [RoleController::class, 'detachUser'])->name('roles.detach-user');
    });

    // ROTAS PARA SUPERADMIN E ADMIN (gestão financeira e principais entidades)
    Route::middleware(['role:superadmin|admin'])->group(function () {
        Route::resource('branches', BranchController::class);
        Route::resource('contracts', ContractController::class);
        Route::resource('solicitation-pricings', SolicitationPricingController::class);
    });

    // ROTAS PARA SUPERADMIN, ADMIN E OPERADOR
    Route::middleware(['role:superadmin|admin|operador'])->group(function () {
        Route::resource('drivers', DriverController::class);
        Route::resource('vehicles', VehicleController::class);
        Route::resource('documents', DocumentController::class);
        Route::resource('driver-licenses', DriverLicenseController::class);
        Route::resource('solicitations', SolicitationController::class);
    });

    // Troca de senha (qualquer autenticado)
    Route::put('/users/{user}/change-password', [UserController::class, 'changePassword'])->name('users.change_password');
});
