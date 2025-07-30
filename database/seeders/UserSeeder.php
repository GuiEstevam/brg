<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Informações “mock” para testes
        $users = [
            [
                'name'     => 'Super Admin',
                'email'    => 'superadmin@admin.com',
                'role'     => 'superadmin',
                'status'   => 'active',
            ],
            [
                'name'     => 'Admin 1',
                'email'    => 'admin1@admin.com',
                'role'     => 'admin',
                'status'   => 'active',
            ],
            [
                'name'     => 'Operador 1',
                'email'    => 'operador1@admin.com',
                'role'     => 'operador',
                'status'   => 'active',
            ],
            [
                'name'     => 'Motorista 1',
                'email'    => 'motorista1@admin.com',
                'role'     => 'motorista',
                'status'   => 'active',
            ],
            [
                'name'     => 'Veiculo 1',
                'email'    => 'veiculo1@admin.com',
                'role'     => 'veiculo',
                'status'   => 'active',
            ]
        ];

        foreach ($users as $info) {
            $user = User::firstOrCreate(
                ['email' => $info['email']],
                [
                    'name'     => $info['name'],
                    'password' => bcrypt('12345678'), // Senha padrão para teste
                    'status'   => $info['status'],
                ]
            );
            // Vincula papel
            $user->syncRoles([$info['role']]);
            // Vincula à empresa id=1
            $user->enterprises()->sync([1]);
        }
    }
}
