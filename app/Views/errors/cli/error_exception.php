<?php
use CodeIgniter\CLI\CLI;
CLI::write('[' . ($exception::class ?? 'Exception') . ']', 'light_gray', 'red');
CLI::write($message ?? ($exception->getMessage() ?? 'Erro na aplicação'));
if (isset($exception)) {
    CLI::write(clean_path($exception->getFile()) . ':' . $exception->getLine(), 'yellow');
    if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE) {
        CLI::write($exception->getTraceAsString());
    }
}
