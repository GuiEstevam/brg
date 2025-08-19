<?php

namespace App\Http\Controllers;

use App\Models\Solicitation;
use App\Models\Enterprise;
use App\Models\User;
use App\Models\Branch;
use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class SolicitationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Solicitation::with('enterprise', 'user', 'branch', 'driver', 'vehicle');

        if ($user->hasRole('superadmin')) {
            // vê tudo
        } elseif ($user->hasRole('admin')) {
            $enterpriseId = current_enterprise_id();
            $enterpriseIds = $enterpriseId ? [$enterpriseId] : $user->enterprises->pluck('id');
            $query->whereIn('enterprise_id', $enterpriseIds);
        } elseif ($user->hasRole('operador')) {
            $enterpriseId = current_enterprise_id();
            $branchId = current_branch_id();
            $query->where('enterprise_id', $enterpriseId);
            if ($branchId) {
                $query->where('branch_id', $branchId);
            }
        } elseif ($user->hasRole('motorista')) {
            $query->where('driver_id', $user->driver_id ?? 0);
        } elseif ($user->hasRole('veiculo')) {
            $query->where('vehicle_id', $user->vehicle_id ?? 0);
        } else {
            abort(403);
        }

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('entity_type')) {
            $query->where('entity_type', $request->entity_type);
        }
        if ($request->filled('research_type')) {
            $query->where('research_type', $request->research_type);
        }
        if ($request->filled('vincle_type')) {
            $query->where('vincle_type', $request->vincle_type);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('entity_value', 'like', "%$search%")
                    ->orWhereHas('driver', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%")
                            ->orWhere('cpf', 'like', "%$search%");
                    })
                    ->orWhereHas('vehicle', function ($q) use ($search) {
                        $q->where('plate', 'like', "%$search%");
                    })
                    ->orWhereHas('enterprise', function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    });
            });
        }

        $solicitations = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();
        $canCreateSolicitation = Gate::allows('create', Solicitation::class);

        return view('solicitations.index', compact('solicitations', 'canCreateSolicitation'));
    }

    public function create()
    {
        Gate::authorize('create', Solicitation::class);

        $user = Auth::user();

        // Motoristas e veículos são globais (não vinculados a empresa)
        $drivers = Driver::orderBy('name')->get();
        $vehicles = Vehicle::orderBy('plate')->get();

        return view('solicitations.create', compact('drivers', 'vehicles'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Solicitation::class);

        $validated = $request->validate([
            'enterprise_id' => 'required|exists:enterprises,id',
            'user_id' => 'required|exists:users,id',
            'branch_id' => 'nullable|exists:branches,id',
            'entity_type' => 'required|in:driver,vehicle,composed',
            'driver_entity_value' => 'nullable|string|max:100',
            'vehicle_entity_value' => 'nullable|string|max:100',
            'driver_select_id' => 'nullable|exists:drivers,id',
            'vehicle_select_id' => 'nullable|exists:vehicles,id',
            'composed_driver_id' => 'nullable|exists:drivers,id',
            'composed_vehicles' => 'nullable|array',
            'research_type' => 'required|in:basic,complete,express',
            'vincle_type' => 'required|in:autonomo,agregado,funcionario',
            'auto_renewal' => 'boolean',
            'notes' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();

        // Validações de contexto
        if ($user->hasRole('admin')) {
            $allowed = current_enterprise_id()
                ? current_enterprise_id() == $validated['enterprise_id']
                : $user->enterprises->pluck('id')->contains($validated['enterprise_id']);
            abort_unless($allowed, 403);
        }
        if ($user->hasRole('operador')) {
            abort_unless(
                current_enterprise_id() == $validated['enterprise_id'] &&
                    (!current_branch_id() || current_branch_id() == ($validated['branch_id'] ?? null)),
                403
            );
        }

        // Processar dados baseado no tipo de entidade
        $entityValue = null;
        $driverId = null;
        $vehicleId = null;

        if ($validated['entity_type'] === 'driver') {
            $entityValue = trim($validated['driver_entity_value'] ?? '');
            $driverId = $validated['driver_select_id'] ?? null;

            if (empty($entityValue) && empty($driverId)) {
                return back()->withErrors(['driver_entity_value' => 'CPF ou motorista cadastrado é obrigatório']);
            }
        } elseif ($validated['entity_type'] === 'vehicle') {
            $entityValue = trim($validated['vehicle_entity_value'] ?? '');
            $vehicleId = $validated['vehicle_select_id'] ?? null;

            if (empty($entityValue) && empty($vehicleId)) {
                return back()->withErrors(['vehicle_entity_value' => 'Placa ou veículo cadastrado é obrigatório']);
            }
        } elseif ($validated['entity_type'] === 'composed') {
            $driverId = $validated['composed_driver_id'] ?? null;
            $vehicleIds = $validated['composed_vehicles'] ?? [];

            if (empty($driverId) || empty($vehicleIds)) {
                return back()->withErrors(['composed_driver_id' => 'Motorista e pelo menos um veículo são obrigatórios para pesquisa composta']);
            }

            // Validar se não há veículos duplicados
            if (count($vehicleIds) !== count(array_unique($vehicleIds))) {
                return back()->withErrors(['composed_vehicles' => 'Não é permitido selecionar o mesmo veículo mais de uma vez']);
            }

            // Para solicitações compostas, criar um valor composto
            $driver = Driver::find($driverId);
            $vehicle = Vehicle::find($vehicleIds[0]); // Usar o primeiro veículo para o valor composto
            $entityValue = "COMPOSED:{$driver->name}-{$vehicle->plate}";
        }

        // Verificar se os campos obrigatórios estão preenchidos
        if (empty($validated['research_type']) || empty($validated['vincle_type'])) {
            return back()->withErrors(['research_type' => 'Tipo de pesquisa e vínculo são obrigatórios']);
        }

        try {
            DB::beginTransaction();

            // Preparar dados da solicitação
            $solicitationData = [
                'enterprise_id' => $validated['enterprise_id'],
                'user_id' => $validated['user_id'],
                'branch_id' => $validated['branch_id'],
                'entity_type' => $validated['entity_type'],
                'entity_value' => $entityValue,
                'driver_id' => $driverId,
                'vehicle_id' => $vehicleId, // Para solicitações simples, mantém o relacionamento direto
                'research_type' => $validated['research_type'],
                'vincle_type' => $validated['vincle_type'],
                'auto_renewal' => $validated['auto_renewal'] ?? false,
                'notes' => $validated['notes'] ?? null,
                'status' => 'pending',
            ];

            // Calcular preço estimado
            $solicitationData['calculated_price'] = $this->calculatePrice($solicitationData);

            // Criar solicitação
            $solicitation = Solicitation::create($solicitationData);

            // Para solicitações compostas, adicionar veículos ao relacionamento many-to-many
            if ($validated['entity_type'] === 'composed' && !empty($vehicleIds)) {
                foreach ($vehicleIds as $index => $vehicleId) {
                    $order = $index + 1;

                    $solicitation->vehicles()->attach($vehicleId, [
                        'order' => $order,
                        'status' => 'active',
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('solicitations.show', $solicitation)
                ->with('success', 'Solicitação criada com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors(['error' => 'Erro ao criar solicitação: ' . $e->getMessage()]);
        }
    }

    public function show(Solicitation $solicitation)
    {
        Gate::authorize('view', $solicitation);

        // Carregar relacionamentos baseados no tipo de entidade
        $relationships = ['enterprise', 'user', 'branch', 'driver', 'researches'];

        if ($solicitation->entity_type === 'vehicle') {
            $relationships[] = 'vehicle';
        } elseif ($solicitation->entity_type === 'composed') {
            $relationships[] = 'vehicles';
        }

        $solicitation->load($relationships);
        return view('solicitations.show', compact('solicitation'));
    }

    public function edit(Solicitation $solicitation)
    {
        Gate::authorize('update', $solicitation);

        $user = Auth::user();

        // Filtrar motoristas e veículos por contexto
        $drivers = Driver::when(!$user->hasRole('superadmin'), function ($q) use ($user) {
            $enterpriseId = current_enterprise_id();
            if ($enterpriseId) {
                $q->where('enterprise_id', $enterpriseId);
            }
        })->orderBy('name')->get();

        $vehicles = Vehicle::when(!$user->hasRole('superadmin'), function ($q) use ($user) {
            $enterpriseId = current_enterprise_id();
            if ($enterpriseId) {
                $q->where('enterprise_id', $enterpriseId);
            }
        })->orderBy('plate')->get();

        return view('solicitations.edit', [
            'solicitation' => $solicitation,
            'drivers' => $drivers,
            'vehicles' => $vehicles,
        ]);
    }

    public function update(Request $request, Solicitation $solicitation)
    {
        Gate::authorize('update', $solicitation);

        $validated = $request->validate([
            'entity_type' => 'required|in:driver,vehicle,composed',
            'entity_value' => 'required_if:entity_type,driver,vehicle|string|max:100',
            'driver_id' => 'nullable|exists:drivers,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'research_type' => 'required|in:basic,complete,express',
            'vincle_type' => 'required|in:autonomo,agregado,funcionario',
            'auto_renewal' => 'boolean',
            'notes' => 'nullable|string|max:1000',
        ]);

        $solicitation->update($validated);

        return redirect()->route('solicitations.show', $solicitation)
            ->with('success', 'Solicitação atualizada com sucesso!');
    }

    public function destroy(Solicitation $solicitation)
    {
        Gate::authorize('delete', $solicitation);

        $solicitation->delete();

        return redirect()->route('solicitations.index')
            ->with('success', 'Solicitação excluída com sucesso!');
    }

    /**
     * Calcular preço da solicitação usando tabela de preços
     */
    private function calculatePrice(array $data): float
    {
        $enterpriseId = $data['enterprise_id'];

        // Buscar configuração de preços da empresa
        $pricing = \App\Models\SolicitationPricing::where('enterprise_id', $enterpriseId)
            ->where('status', 'active')
            ->first();

        if (!$pricing) {
            // Se não houver configuração, usar preços padrão
            return $this->calculateDefaultPrice($data);
        }

        $basePrice = 0;

        // Calcular preço base por tipo de entidade
        switch ($data['entity_type']) {
            case 'driver':
                $basePrice = $pricing->individual_driver_price ?? 50.00;
                break;
            case 'vehicle':
                $basePrice = $pricing->individual_vehicle_price ?? 50.00;
                break;
            case 'composed':
                $basePrice = $pricing->unified_price ?? 75.00;

                // Adicionar preço por veículo adicional (se houver múltiplos veículos)
                if (isset($data['composed_vehicles']) && count($data['composed_vehicles']) > 1) {
                    $additionalVehicles = count($data['composed_vehicles']) - 1;

                    if ($additionalVehicles >= 1 && $pricing->unified_additional_vehicle_2) {
                        $basePrice += $pricing->unified_additional_vehicle_2;
                    }
                    if ($additionalVehicles >= 2 && $pricing->unified_additional_vehicle_3) {
                        $basePrice += $pricing->unified_additional_vehicle_3;
                    }
                    if ($additionalVehicles >= 3 && $pricing->unified_additional_vehicle_4) {
                        $basePrice += $pricing->unified_additional_vehicle_4;
                    }
                }
                break;
        }

        // Ajuste por tipo de pesquisa (se necessário)
        switch ($data['research_type']) {
            case 'express':
                $basePrice *= 0.8; // 20% de desconto para express
                break;
            case 'complete':
                $basePrice *= 1.2; // 20% de acréscimo para completa
                break;
        }

        // Ajuste por tipo de vínculo (se necessário)
        switch ($data['vincle_type']) {
            case 'funcionario':
                $basePrice *= 1.1; // 10% de acréscimo para funcionário
                break;
            case 'agregado':
                $basePrice *= 1.05; // 5% de acréscimo para agregado
                break;
        }

        return round($basePrice, 2);
    }

    /**
     * Calcular preço padrão quando não há configuração
     */
    private function calculateDefaultPrice(array $data): float
    {
        $basePrice = 50.00;

        // Ajuste por tipo de pesquisa
        switch ($data['research_type']) {
            case 'express':
                $basePrice *= 0.7;
                break;
            case 'complete':
                $basePrice *= 1.3;
                break;
        }

        // Ajuste por tipo de entidade
        if ($data['entity_type'] === 'composed') {
            $basePrice *= 1.5;
        }

        // Ajuste por vínculo
        if ($data['vincle_type'] === 'funcionario') {
            $basePrice *= 1.2;
        }

        return round($basePrice, 2);
    }
}
