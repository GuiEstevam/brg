<?php

namespace App\Helpers;

class PermissionHelper
{
    /**
     * Retorna o nome da permissão em formato legível: "Visualizar Usuários", etc.
     * Suporta pluralização, labels customizados e expansão futura.
     *
     * @param string $permission
     * @return string
     */
    public static function humanize($permission)
    {
        if (strpos($permission, '.') === false) {
            return __(ucfirst(str_replace(['_', '-'], ' ', $permission)));
        }

        [$entidade, $acao] = explode('.', $permission, 2);

        $labelsEntidade = [
            'usuarios'      => 'Usuários',
            'empresas'      => 'Empresas',
            'filiais'       => 'Filiais',
            'papeis'        => 'Papéis',
            'permissoes'    => 'Permissões',
            'veiculos'      => 'Veículos',
            'motoristas'    => 'Motoristas',
            'contratos'     => 'Contratos',
            'dashboard'     => 'Dashboard',
            'relatorios'    => 'Relatórios',
            'auditoria'     => 'Auditoria',
            'configuracoes' => 'Configurações',
            'notificacoes'  => 'Notificações',
            // Adicione outras entidades conforme seu negócio evoluir
        ];

        $labelsAcao = [
            'visualizar'      => 'Visualizar',
            'criar'           => 'Criar',
            'editar'          => 'Editar',
            'excluir'         => 'Excluir',
            'alterar-senha'   => 'Alterar Senha',
            'gerar-relatorio' => 'Gerar Relatório',
            'acessos'         => 'Acessos',
            'exportar'        => 'Exportar',
            'gerenciar'       => 'Gerenciar',
            // Outras ações, se precisarem ser customizadas
        ];

        $entidadeFormatada = __($labelsEntidade[$entidade] ?? ucfirst(str_replace(['_', '-'], ' ', $entidade)));
        $acaoFormatada     = __($labelsAcao[$acao] ?? ucfirst(str_replace(['_', '-'], ' ', $acao)));

        return "{$acaoFormatada} {$entidadeFormatada}";
    }

    /**
     * Agrupa uma Collection de permissões pela entidade (primeira parte antes do ponto).
     *
     * @param \Illuminate\Support\Collection $permissions
     * @return \Illuminate\Support\Collection
     */
    public static function groupPermissionsByEntity($permissions)
    {
        return $permissions->groupBy(function ($perm) {
            return explode('.', $perm->name, 2)[0] ?? '';
        })->sortKeys();
    }

    /**
     * Retorna o label amigável do grupo/entity.
     *
     * @param string $entity
     * @return string
     */
    public static function entityLabel($entity)
    {
        $labels = [
            'usuarios'      => 'Usuários',
            'empresas'      => 'Empresas',
            'filiais'       => 'Filiais',
            'papeis'        => 'Papéis',
            'permissoes'    => 'Permissões',
            'veiculos'      => 'Veículos',
            'motoristas'    => 'Motoristas',
            'contratos'     => 'Contratos',
            'dashboard'     => 'Dashboard',
            'relatorios'    => 'Relatórios',
            'auditoria'     => 'Auditoria',
            'configuracoes' => 'Configurações',
            'notificacoes'  => 'Notificações',
            // Expanda aqui conforme necessário
        ];
        return $labels[$entity] ?? ucfirst($entity);
    }

    /**
     * Retorna o nome do ícone Ionicon correspondente à entidade.
     *
     * @param string $entity
     * @return string
     */
    public static function entityIcon(string $entity): string
    {
        $icons = [
            'usuarios'      => 'person-outline',
            'empresas'      => 'business-outline',
            'filiais'       => 'git-branch-outline',
            'papeis'        => 'person-badge-outline',
            'permissoes'    => 'key-outline',
            'veiculos'      => 'car-outline',
            'motoristas'    => 'id-card-outline',
            'contratos'     => 'document-outline',
            'dashboard'     => 'stats-chart-outline',
            'relatorios'    => 'pie-chart-outline',
            'auditoria'     => 'search-circle-outline',
            'configuracoes' => 'settings-outline',
            'notificacoes'  => 'notifications-outline',
            // Adicione novas entidades e ícones se necessário
        ];
        return $icons[$entity] ?? 'ellipse-outline';
    }
}
