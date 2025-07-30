<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Usuários
            'usuarios.visualizar',
            'usuarios.criar',
            'usuarios.editar',
            'usuarios.excluir',
            'usuarios.alterar-senha',

            // Empresas
            'empresas.visualizar',
            'empresas.criar',
            'empresas.editar',
            'empresas.excluir',

            // Filiais
            'filiais.visualizar',
            'filiais.criar',
            'filiais.editar',
            'filiais.excluir',

            // Papéis e permissões
            'papeis.visualizar',
            'papeis.criar',
            'papeis.editar',
            'papeis.excluir',
            'permissoes.visualizar',
            'permissoes.criar',
            'permissoes.editar',
            'permissoes.excluir',

            // Veículos
            'veiculos.visualizar',
            'veiculos.criar',
            'veiculos.editar',
            'veiculos.excluir',

            // Motoristas
            'motoristas.visualizar',
            'motoristas.criar',
            'motoristas.editar',
            'motoristas.excluir',

            // Contratos e regras de preço
            'contratos.visualizar',
            'contratos.criar',
            'contratos.editar',
            'contratos.excluir',
            'contratos.gerar-relatorio',

            // Dashboards e relatórios
            'dashboard.visualizar',
            'relatorios.acessos',
            'relatorios.empresas',
            'relatorios.veiculos',

            // Auditoria e logs
            'auditoria.visualizar',
            'auditoria.exportar',

            // Outras permissões customizadas
            'configuracoes.gerenciar',
            'notificacoes.visualizar',
            'notificacoes.gerenciar',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate([
                'name' => $perm,
                'guard_name' => 'web',
            ]);
        }
    }
}
