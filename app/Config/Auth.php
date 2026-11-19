<?php
namespace Config;

use CodeIgniter\Shield\Config\Auth as ShieldAuth;

class Auth extends ShieldAuth
{
    public array $redirects = [
        'register' => '/',
        'login' => '/admin',
        'logout' => '/login',
    ];
}