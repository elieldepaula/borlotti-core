<?php

/**
 * Copyright (c) 2025 - Borlotti Project.
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright   Copyright (c) Eliel de Paula <elieldepaula@gmail.com>
 * @license     https://www.opensource.org/licenses/mit-license.php MIT License
 */

declare(strict_types=1);

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

/**
 * @todo Ajustar o setup dos paths via configuração.
 */
return [
    'paths' => [
        'migrations' => __DIR__ . '/../../app/Database/Migrations/',
        'seeds' => __DIR__ . '/../../app/Database/Seeds/',
    ],
    'environments' => [
        'default_migration_table' => 'migrations',
        'default_environment' => $_ENV['APP_ENV'] ?? 'development',
        'development' => [
            'adapter' => $_ENV['DB_DRIVER'],
            'host' => $_ENV['DB_HOST'],
            'name' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'pass' => $_ENV['DB_PASS'],
            'port' => $_ENV['DB_PORT']??3306,
            'charset' => $_ENV['DB_CHARSET']?? 'utf8',
        ],
        'production' => [
            'adapter' => $_ENV['DB_DRIVER'],
            'host' => $_ENV['DB_HOST'],
            'name' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'pass' => $_ENV['DB_PASS'],
            'port' => $_ENV['DB_PORT']??3306,
            'charset' => $_ENV['DB_CHARSET']?? 'utf8',
        ]
    ],
];
