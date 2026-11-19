<?php
namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;
use CodeIgniter\Shield\Filters\SessionAuth;
use CodeIgniter\Shield\Filters\GroupFilter;
use CodeIgniter\Shield\Filters\PermissionFilter;

class Filters extends BaseFilters
{
    public array $aliases = [
        'csrf' => CSRF::class,
        'toolbar' => DebugToolbar::class,
        'honeypot' => Honeypot::class,
        'invalidchars' => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'session' => SessionAuth::class,
        'group' => GroupFilter::class,
        'permission' => PermissionFilter::class,
    ];

    public array $required = [
        'before' => [],
        'after' => ['toolbar'],
    ];

    public array $globals = [
        'before' => ['csrf' => ['except' => ['auth/*']]],
        'after' => [],
    ];

    public array $methods = [];
    public array $filters = [];
}