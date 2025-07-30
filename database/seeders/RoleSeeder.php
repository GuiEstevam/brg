<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Permissões por papel.
     *
     * IMPORTANTE: motorista e veiculo NÃO possuem permissão de excluir motoristas/veículos,
     * apenas superadmin pode todas as exclusões. Admin pode excluir motoristas/veículos APENAS se não houverem vínculos (aplique a validação na app).
     */
    protected $permissionsByRole = [
        'superadmin' => [
            '*'
        ],

        'admin' => [
            // Usuários e empresas
            'usuarios.visualizar',
            'usuarios.criar',
            'usuarios.editar',
            'usuarios.excluir',
            'usuarios.alterar-senha',
            'empresas.visualizar',
            'empresas.editar',
            'filiais.visualizar',
            'filiais.criar',
            'filiais.editar',
            'filiais.excluir',

            // Papéis (visualização)
            'papeis.visualizar',

            // Veículos e motoristas (excluir apenas se não houver vínculo — valide no controller)
            'veiculos.visualizar',
            'veiculos.criar',
            'veiculos.editar',
            'veiculos.excluir',
            'motoristas.visualizar',
            'motoristas.criar',
            'motoristas.editar',
            'motoristas.excluir',

            // Contratos e operação
            'contratos.visualizar',
            'contratos.criar',
            'contratos.editar',
            'contratos.excluir',
            'contratos.gerar-relatorio',

            // Relatórios/dashboards/notificações
            'dashboard.visualizar',
            'relatorios.acessos',
            'relatorios.empresas',
            'relatorios.veiculos',
            'notificacoes.visualizar',
            'notificacoes.gerenciar',
        ],

        'operador' => [
            'filiais.visualizar',
            'veiculos.visualizar',
            'veiculos.criar',
            'veiculos.editar',
            'motoristas.visualizar',
            'motoristas.criar',
            'motoristas.editar',
            'contratos.visualizar',
            'contratos.criar',
            'contratos.editar',
            'dashboard.visualizar',
            'notificacoes.visualizar'
        ],

        'motorista' => [
            // Pode manter/editar seus próprios dados, mas NÃO pode excluir motoristas
            'dashboard.visualizar',
            'motoristas.visualizar',
            'motoristas.editar',
            'notificacoes.visualizar',
        ],

        'veiculo' => [
            // Idem motorista
            'dashboard.visualizar',
            'veiculos.visualizar',
            'veiculos.editar',
            'notificacoes.visualizar',
        ]
    ];

    public function run(): void
    {
        foreach ($this->permissionsByRole as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName], ['guard_name' => 'web']);
            if (in_array('*', $perms)) {
                $role->syncPermissions(Permission::pluck('name')->toArray());
            } else {
                $role->syncPermissions($perms);
            }
        }
    }
}
