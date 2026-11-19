<?php
namespace Config;

use CodeIgniter\Shield\Config\AuthGroups as ShieldAuthGroups;

class AuthGroups extends ShieldAuthGroups
{
    public array $groups = [
        'admin' => [
            'title' => 'Administrador',
            'description' => 'Acesso ao painel e à edição dos conteúdos',
        ],
        'user' => [
            'title' => 'Usuário',
            'description' => 'Conta padrão do sistema',
        ],
    ];

    public string $defaultGroup = 'user';

    public array $permissions = [
        'admin.access' => 'Acessar o painel administrativo',
    ];

    public array $matrix = [
        'admin' => ['admin.*'],
        'user' => [],
    ];
}