<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rotas para cadastro rápido
Route::middleware(['auth', 'web'])->group(function () {
    Route::post('/drivers/quick-create', function (Request $request) {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'cpf' => 'required|string|max:14|unique:drivers,cpf',
                'cnh' => 'required|string|max:20',
                'phone' => 'nullable|string|max:20',
            ]);

            $driver = \App\Models\Driver::create([
                'name' => $validated['name'],
                'cpf' => $validated['cpf'],
                'cnh' => $validated['cnh'],
                'phone' => $validated['phone'],
                'enterprise_id' => current_enterprise_id(),
            ]);

            return response()->json([
                'success' => true,
                'driver' => $driver,
                'message' => 'Motorista criado com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    });

    Route::post('/vehicles/quick-create', function (Request $request) {
        try {
            $validated = $request->validate([
                'plate' => 'required|string|max:8|unique:vehicles,plate',
                'model' => 'required|string|max:100',
                'brand' => 'required|string|max:100',
                'year' => 'required|integer|min:1900|max:2030',
                'color' => 'nullable|string|max:50',
            ]);

            $vehicle = \App\Models\Vehicle::create([
                'plate' => strtoupper($validated['plate']),
                'model' => $validated['model'],
                'brand' => $validated['brand'],
                'year' => $validated['year'],
                'color' => $validated['color'],
                'enterprise_id' => current_enterprise_id(),
            ]);

            return response()->json([
                'success' => true,
                'vehicle' => $vehicle,
                'message' => 'Veículo criado com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    });
});
