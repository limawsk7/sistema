<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Configuração de tratamento de erros do CodeIgniter.
 */
class Exceptions extends BaseConfig
{
    /**
     * Códigos HTTP que não devem ser registrados como erros.
     *
     * @var list<int>
     */
    public array $ignoreCodes = [404];

    /**
     * Diretório das páginas de erro da aplicação.
     */
    public string $errorViewPath = APPPATH . 'Views/errors';

    /**
     * Registra erros no log.
     */
    public bool $log = true;

    /**
     * Dados adicionais para o logger.
     *
     * @var array<string, mixed>
     */
    public array $logger = [];

    /**
     * Não exibe dados sensíveis nos rastros de erro.
     */
    public array $sensitiveDataInTrace = [];
}
