<?php

return [
    'namespace' => 'Plugins',

    'setup' => [
        'config' => base_path('plugin.json'),
        'cache-key' => 'laravel-plugin.setup',
        'cache-lifetime' => 604800,
    ],

    'url_prefix' => '/laravel-plugin',

    'paths' => [
        /*
        |--------------------------------------------------------------------------
        | Plugin Path
        |--------------------------------------------------------------------------
        |
        | This path used for save the generated plugin.
        |
        */
        'plugin' => base_path('plugins'),

        /*
         |--------------------------------------------------------------------------
         | Generator path
         |--------------------------------------------------------------------------
         |
         | Customize the initialization directory structure.
         |
         */
        'generator' => [
            'controller' => 'App/Http/Controllers',
            'model' => 'App/Models',
            'provider' => 'App/Providers',
            // 'console' => 'App/Console',
            'middleware' => 'App/Http/Middleware',
            'request' => 'App/Http/Requests',
            // 'listener' => 'App/Listeners',
            // 'event' => 'App/Events',
            'policies' => 'App/Policies',
            // 'rules' => 'App/Rules',
            // 'jobs' => 'App/Jobs',
            // 'notifications' => 'App/Notifications',
            'migration' => 'Database/Migrations',
            'seeder' => 'Database/Seeders',
            'factory' => 'Database/Factories',
            'test' => 'Tests/Unit',
            'test-feature' => 'Tests/Feature',
            'js' => 'resources/js',
            'css' => 'resources/css',
            'assets' => 'resources/assets',
            'lang' => 'resources/lang',
            'views' => 'resources/views',
            'config' => 'Config',
            'routes' => 'Routes',
        ],

        /*
         |--------------------------------------------------------------------------
         | Stub path
         |--------------------------------------------------------------------------
         |
         | Customize the properties of the makefile.
         */
        'stub' => [
            'laravel-plugin.json' => [
                'from' => 'laravel-plugin.stub',
                'to' => '/laravel-plugin.json',
            ],
            'config' => ['from' => 'config.stub', 'to' => '/Config/config.php'],
            'AppServiceProvider' => [
                'from' => 'providers/AppServiceProvider.stub',
                'to' => '/App/Providers/AppServiceProvider.php',
            ],
            'RouteServiceProvider' => [
                'from' => 'providers/RouteServiceProvider.stub',
                'to' => '/App/Providers/RouteServiceProvider.php',
            ],
            'LICENSE' => ['from' => 'LICENSE.stub', 'to' => '/LICENSE.md'],
            'README' => ['from' => 'README.stub', 'to' => '/README.md'],
            'composer.json' => ['from' => 'composer.stub', 'to' => '/composer.json'],
            'routes/api' => ['from' => 'routes/api.stub', 'to' => '/Routes/api.php'],
            'routes/web' => ['from' => 'routes/web.stub', 'to' => '/Routes/web.php'],
        ],
    ],
];
