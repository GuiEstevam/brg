<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Enterprise;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Solicitation;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = [];

        // SUPERADMIN: visão global do sistema
        if ($user->hasRole('superadmin')) {
            $data['totalUsers'] = User::count();
            $data['totalEnterprises'] = Enterprise::count();
            $data['totalDrivers'] = Driver::count();
            $data['totalVehicles'] = Vehicle::count();
            $data['totalSolicitations'] = Solicitation::count();
            $data['totalConfigs'] = 0; // Ajuste conforme necessário
            $data['chartLabels'] = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
            $data['chartData'] = [10, 20, 18, 25, 22, 30];
        }

        // ADMIN: visão limitada à empresa do contexto (todas filiais)
        if ($user->hasRole('admin')) {
            $enterpriseIds = current_enterprise_id()
                ? [current_enterprise_id()]
                : $user->enterprises->pluck('id')->toArray();

            // Motoristas já aproveitados em solicitações da(s) empresa(s)
            $data['totalDrivers'] = Driver::whereHas('solicitations', function ($q) use ($enterpriseIds) {
                $q->whereIn('enterprise_id', $enterpriseIds);
            })->distinct()->count();

            // Veículos já aproveitados em solicitações da(s) empresa(s)
            $data['totalVehicles'] = Vehicle::whereHas('solicitations', function ($q) use ($enterpriseIds) {
                $q->whereIn('enterprise_id', $enterpriseIds);
            })->distinct()->count();

            // Usuários atrelados à empresa pela relação (como já no modelo)
            $data['totalEnterpriseUsers'] = User::whereHas('enterprises', function ($q) use ($enterpriseIds) {
                $q->whereIn('enterprises.id', $enterpriseIds);
            })->count();

            // Total de solicitações da(s) empresa(s)
            $data['totalSolicitations'] = Solicitation::whereIn('enterprise_id', $enterpriseIds)->count();

            $data['chartLabels'] = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
            $data['chartData'] = [5, 8, 12, 7, 10, 15];
        }

        // OPERADOR: solicitações da empresa/filial do contexto
        if ($user->hasRole('operador')) {
            $enterpriseId = current_enterprise_id();
            $branchId = current_branch_id();

            $query = Solicitation::query();
            if ($enterpriseId) {
                $query->where('enterprise_id', $enterpriseId);
            }
            if ($branchId) {
                $query->where('branch_id', $branchId);
            }

            $data['pendingSolicitations'] = (clone $query)->where('status', 'pending')->count();
            $data['completedSolicitations'] = (clone $query)->where('status', 'completed')->count();

            $data['chartLabels'] = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
            $data['chartData'] = [3, 6, 4, 9, 7, 8];
        }

        // MOTORISTA: solicitações do próprio motorista (ajuste para seu modelo se necessário)
        if ($user->hasRole('motorista')) {
            // Supondo que o User tem relação/foreign para Driver
            $driverId = $user->driver_id ?? $user->id;
            $data['mySolicitations'] = Solicitation::where('driver_id', $driverId)->count();

            $data['chartLabels'] = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
            $data['chartData'] = [1, 2, 2, 1, 3, 0];
        }

        // VEICULO: personalize conforme necessidade
        if ($user->hasRole('veiculo')) {
            $vehicleId = $user->vehicle_id ?? $user->id;
            $data['mySolicitations'] = Solicitation::whereHas('vehicles', function ($q) use ($vehicleId) {
                $q->where('vehicles.id', $vehicleId);
            })->count();

            $data['chartLabels'] = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
            $data['chartData'] = [0, 1, 0, 2, 1, 0];
        }

        $data['user'] = $user;
        return view('dashboard', $data);
    }
}
