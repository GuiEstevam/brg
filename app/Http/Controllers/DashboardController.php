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

        // MASTER: visão global do sistema
        if ($user->hasRole('master')) {
            $data['totalUsers'] = User::count();
            $data['totalEnterprises'] = Enterprise::count();
            $data['totalSolicitations'] = Solicitation::count();
            $data['totalConfigs'] = 0; // Substitua por métrica real se houver
            // Exemplo de dados para gráfico
            $data['chartLabels'] = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
            $data['chartData'] = [10, 20, 18, 25, 22, 30];
        }

        // ADMIN: visão da empresa do admin
        if ($user->hasRole('admin')) {
            $enterpriseId = $user->enterprise_id;
            $data['totalEnterpriseUsers'] = User::where('enterprise_id', $enterpriseId)->count();
            $data['totalDrivers'] = Driver::where('enterprise_id', $enterpriseId)->count();
            $data['totalVehicles'] = Vehicle::where('enterprise_id', $enterpriseId)->count();
            $data['chartLabels'] = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
            $data['chartData'] = [5, 8, 12, 7, 10, 15];
        }

        // OPERADOR: solicitações da empresa
        if ($user->hasRole('operador')) {
            $enterpriseId = $user->enterprise_id;
            $data['pendingSolicitations'] = Solicitation::where('enterprise_id', $enterpriseId)->where('status', 'pending')->count();
            $data['completedSolicitations'] = Solicitation::where('enterprise_id', $enterpriseId)->where('status', 'completed')->count();
            $data['chartLabels'] = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
            $data['chartData'] = [3, 6, 4, 9, 7, 8];
        }

        // MOTORISTA: solicitações do próprio motorista
        if ($user->hasRole('motorista')) {
            $data['mySolicitations'] = Solicitation::where('driver_id', $user->driver_id)->count();
            $data['chartLabels'] = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
            $data['chartData'] = [1, 2, 2, 1, 3, 0];
        }

        // VEICULO: dados do veículo (exemplo genérico)
        if ($user->hasRole('veiculo')) {
            $data['chartLabels'] = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
            $data['chartData'] = [0, 1, 0, 2, 1, 0];
        }

        // Sempre envie o user para a view
        $data['user'] = $user;

        return view('dashboard', $data);
    }
}
