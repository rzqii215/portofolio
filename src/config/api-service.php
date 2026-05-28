<?php

return [
    /*
    |--------------------------------------------------------------------------
    | API Service Navigation
    |--------------------------------------------------------------------------
    |
    | Konfigurasi menu API Token pada sidebar Filament.
    |
    */

    'navigation' => [
        'token' => [
            'cluster' => null,
            'group' => 'User',
            'sort' => -1,
            'icon' => 'heroicon-o-key',
            'should_register_navigation' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | API Service Models
    |--------------------------------------------------------------------------
    */

    'models' => [
        'token' => [
            'enable_policy' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | API Service Route
    |--------------------------------------------------------------------------
    |
    | panel_prefix true membuat endpoint menjadi:
    | /api/admin/prestasis
    | /api/admin/profil-mahasiswas
    | dan seterusnya.
    |
    */

    'route' => [
        'panel_prefix' => true,
        'use_resource_middlewares' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | API Service Tenancy
    |--------------------------------------------------------------------------
    */

    'tenancy' => [
        'enabled' => false,
        'awareness' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Login Rules
    |--------------------------------------------------------------------------
    */

    'login-rules' => [
        'email' => 'required|email',
        'password' => 'required',
    ],

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    */

    'login-middleware' => [],

    'logout-middleware' => [
        'auth:sanctum',
    ],

    /*
    |--------------------------------------------------------------------------
    | Permission Middleware
    |--------------------------------------------------------------------------
    |
    | Dibuat false supaya API tidak langsung kena 403 dari Filament Shield.
    | Untuk kebutuhan UTS/demo, ini lebih aman.
    |
    */

    'use-spatie-permission-middleware' => false,
];