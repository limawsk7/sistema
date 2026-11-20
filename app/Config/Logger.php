<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Configuração de registro de logs do CodeIgniter.
 */
class Logger extends BaseConfig
{
    /**
     * Nível mínimo de log: 0 desativa; 1-9 aumenta o detalhamento.
     */
    public int $threshold = 4;

    /**
     * Formato de data utilizado nos arquivos de log.
     */
    public string $dateFormat = 'Y-m-d H:i:s';

    /**
     * Manipuladores responsáveis por gravar os logs.
     */
    public array $handlers = [
        \CodeIgniter\Log\Handlers\FileHandler::class => [
            'handles' => [
                'critical',
                'alert',
                'emergency',
                'debug',
                'error',
                'info',
                'notice',
                'warning',
            ],
            'fileExtension' => '',
            'filePermissions' => 0644,
            'path' => '',
        ],
    ];
}
