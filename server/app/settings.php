<?php

// set database parameters based on server
if ($_SERVER['HTTP_HOST'] == '192.168.33.99') {
    $db_array = array(
        'host' => '127.0.0.1',
        'user' => 'root',
        'pass' => '12345678',
        'dbname' => 'mydb'
    );
} else {
    $db_array = array(
        'host' => '127.0.0.1',
        'user' => 'root',
        'pass' => '',
        'dbname' => 'pogo'
    );
}



return [
    'settings' => [
        // comment this line when deploy to production environment
        'displayErrorDetails' => true,
        // View settings
        'view' => [
            'template_path' => __DIR__ . '/templates',
            'twig' => [
                'cache' => __DIR__ . '/../cache/twig',
                'debug' => true,
                'auto_reload' => true,
            ],
        ],

        'dbSettings' => array(
            'db' => $db_array,
        ),

        // doctrine settings
        //이거 지우면 홈페이지 안됨
        'doctrine' => [
            'meta' => [
                'entity_path' => [
                    __DIR__ . '/src/models'
                ],
                'auto_generate_proxies' => true,
                'proxy_dir' =>  __DIR__.'/../cache/proxies',
                'cache' => null,
            ],
            'connection' => [
                'driver'   => 'pdo_mysql',
                'host'     => '127.0.0.1',
                'port'     => 8889,
                'dbname'   => 'blog',
                'user'     => 'root',
                'password' => 'root',
            ]
        ],

        // monolog settings
        'logger' => [
            'name' => 'app',
            'path' => __DIR__ . '/../log/app.log',
        ],
    ],
];
