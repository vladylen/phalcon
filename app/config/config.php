<?php

defined('APP_PATH') || define('APP_PATH', realpath('.'));

return new \Phalcon\Config(
    [
        'database'    => [
            'adapter'  => 'Mysql',
            'host'     => 'localhost',
            'username' => 'root',
            'password' => '',
            'dbname'   => 'phalcon_db',
            'charset'  => 'utf8',
        ],
        'application' => [
            'controllersDir' => APP_PATH . '/app/controllers/',
            'modelsDir'      => APP_PATH . '/app/models/',
            'behavioursDir'  => APP_PATH . '/app/models/behaviours/',
            'migrationsDir'  => APP_PATH . '/app/migrations/',
            'viewsDir'       => APP_PATH . '/app/views/',
            'pluginsDir'     => APP_PATH . '/app/plugins/',
            'libraryDir'     => APP_PATH . '/app/library/',
            'cacheDir'       => APP_PATH . '/app/cache/',
            'baseUri'        => '/phalcon.local/',
        ]
    ]
);
