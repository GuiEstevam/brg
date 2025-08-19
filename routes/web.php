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
use App\Http\Controllers\ContextController;
use App\Http\Controllers\AuditLogController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    // CONTEXTO (seleção de empresa/filial)
    Route::get('/context/select', [ContextController::class, 'select'])->name('context.select');
    Route::post('/context/set-empresa', [ContextController::class, 'setEmpresa'])->name('context.set-empresa');
    Route::post('/context/set-filial', [ContextController::class, 'setFilial'])->name('context.set-filial');
    Route::post('/context/trocar', [ContextController::class, 'trocar'])->name('context.trocar');


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ROTAS SÓ PARA SUPERADMIN
    Route::middleware(['role:superadmin'])->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        // Rotas extras para gerenciamento de usuários/papéis
        Route::get('roles/{role}/attach-user', [RoleController::class, 'attachUserForm'])->name('roles.attach-user');
        Route::post('roles/{role}/attach-user', [RoleController::class, 'attachUser'])->name('roles.attach-user.submit');
        Route::delete('roles/{role}/detach-user/{user}', [RoleController::class, 'detachUser'])->name('roles.detach-user');
    });

    // ROTAS PARA SUPERADMIN E ADMIN (gestão financeira e principais entidades)
    Route::middleware(['role:superadmin|admin'])->group(function () {
        // Empresas: admin pode ver/editar sua própria, superadmin CRUD total (policy garante)
        Route::resource('enterprises', EnterpriseController::class);

        Route::resource('branches', BranchController::class);
        Route::resource('contracts', ContractController::class);
        Route::get('contracts-export', [ContractController::class, 'exportExcel'])->name('contracts.export.excel');
        Route::resource('solicitation-pricings', SolicitationPricingController::class);

        // Auditoria
        Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
        Route::get('audit-logs/export/csv', [AuditLogController::class, 'exportCsv'])->name('audit-logs.export.csv');
        Route::get('audit-logs/export/excel', [AuditLogController::class, 'exportExcel'])->name('audit-logs.export.excel');
    });

    // ROTAS PARA SUPERADMIN, ADMIN E OPERADOR
    Route::middleware(['role:superadmin|admin|operador'])->group(function () {
        // Usuários: todos acessam; políticas restringem criação/edição/remoção
        Route::resource('users', UserController::class);
        Route::resource('drivers', DriverController::class);
        Route::resource('vehicles', VehicleController::class);
        Route::resource('documents', DocumentController::class);
        Route::resource('driver-licenses', DriverLicenseController::class);
        Route::resource('solicitations', SolicitationController::class);
    });

    // Troca de senha (qualquer autenticado)
    Route::put('/users/{user}/change-password', [UserController::class, 'changePassword'])->name('users.change_password');
});
