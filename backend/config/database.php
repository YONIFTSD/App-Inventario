<?php

return [

   'default' => 'mysql',
   'migrations' => 'migrations',
   'connections' => [
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST'),
            'port'      => env('DB_PORT'),
            'database'  => env('DB_DATABASE'),
            'username'  => env('DB_USERNAME'),
            'password'  => env('DB_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
         ],

        'operadores' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST_OPERADORES'),
            'port'      => env('DB_PORT_OPERADORES'),
            'database'  => env('DB_DATABASE_OPERADORES'),
            'username'  => env('DB_USERNAME_OPERADORES'),
            'password'  => env('DB_PASSWORD_OPERADORES'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],

        'inversiones' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST_INVERSIONES'),
            'port'      => env('DB_PORT_INVERSIONES'),
            'database'  => env('DB_DATABASE_INVERSIONES'),
            'username'  => env('DB_USERNAME_INVERSIONES'),
            'password'  => env('DB_PASSWORD_INVERSIONES'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],
    ],
];