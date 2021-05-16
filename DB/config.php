<?php

'mysql' => [
    'driver' => 'mysql',
    'host' => env('DB_HOST', 'remotemysql.com'),
    'port' => env('DB_PORT', '3306'),
    'database' => env('DB_DATABASE', 'nytupLSUX3'),
    'username' => env('DB_USERNAME', 'nytupLSUX3'),
    'password' => env('DB_PASSWORD', 'SJfl3Use3K'),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'options' => [PDO::ATTR_EMULATE_PREPARES => true],
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
];

/*
define("DB_DSN", "mysql:host=database;dbname=mto");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "password");
*/

/*
define("DB_DSN", "mysql:dbname=ngadomsk_grc");
define("DB_USERNAME", "ngadomsk_grcuser");
define("DB_PASSWORD", 'Soccer09!');
*/