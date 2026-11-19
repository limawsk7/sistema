<?php
namespace Config;

use CodeIgniter\Shield\Config\Auth as ShieldAuth;

class Auth extends ShieldAuth
{
    public array $views = [
        'login' => 'auth/login',
        'register' => 'auth/register',
        'layout' => 'auth/layout',
    ];

    public array $redirects = [
        'register' => '/',
        'login' => '/',
        'logout' => 'login',
        'force_reset' => '/',
        'permission_denied' => '/',
        'group_denied' => '/',
    ];

    public bool $allowMagicLinkLogins = false;
}