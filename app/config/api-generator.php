<?php

return [

    'driver' => 'eloquent',

    'prefix' => 'v1',

    'resources' => [
        'companies.messages'
    ],

    'paths' => [
        'routes' => app_path('routes.php'),
        'models' => app_path('models'),
        'controllers' => app_path('controllers')
    ]

];