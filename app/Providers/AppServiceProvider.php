<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Contract;
use App\Policies\ContractPolicy;
use App\Models\Solicitation;
use App\Policies\SolicitationPolicy;
use App\Models\SolicitationPricing;
use App\Policies\SolicitationPricingPolicy;
use App\Models\Branch;
use App\Policies\BranchPolicy;
use App\Models\Driver;
use App\Policies\DriverPolicy;
use App\Models\Vehicle;
use App\Policies\VehiclePolicy;
use App\Models\Document;
use App\Policies\DocumentPolicy;
use App\Models\DriverLicense;
use App\Policies\DriverLicensePolicy;
use App\Policies\EnterprisePolicy;
use App\Models\Enterprise;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Contract::class, ContractPolicy::class);
        Gate::policy(Solicitation::class, SolicitationPolicy::class);
        Gate::policy(SolicitationPricing::class, SolicitationPricingPolicy::class);
        Gate::policy(Branch::class, BranchPolicy::class);
        Gate::policy(Driver::class, DriverPolicy::class);
        Gate::policy(Vehicle::class, VehiclePolicy::class);
        Gate::policy(Document::class, DocumentPolicy::class);
        Gate::policy(DriverLicense::class, DriverLicensePolicy::class);
        Gate::policy(Enterprise::class, EnterprisePolicy::class);

        // Compartilha contexto com todas as views
        view()->share('contextEmpresaNome', session('empresa_nome'));
        view()->share('contextFilialNome', session('filial_nome'));
    }
}
