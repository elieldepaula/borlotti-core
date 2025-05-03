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

$dotenv = Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

return [
    'paths' => [
        'migrations' => BASE_PATH . 'src/Database/Migrations/',
        'seeds' => BASE_PATH . 'src/Database/Seeds/',
    ],
    'environments' => [
        'default_migration_table' => 'migrations',
        'default_environment' => $_ENV['APP_ENV'] ?? 'development',
        'development' => [
            'adapter' => $_ENV['DEV_DB_DRIVER'],
            'host' => $_ENV['DEV_DB_HOST'],
            'name' => $_ENV['DEV_DB_NAME'],
            'user' => $_ENV['DEV_DB_USER'],
            'pass' => $_ENV['DEV_DB_PASS'],
            'port' => $_ENV['DEV_DB_PORT']??3306,
            'charset' => $_ENV['DEV_DB_CHARSET']?? 'utf8',
        ],
        'production' => [
            'adapter' => $_ENV['PRD_DB_DRIVER'],
            'host' => $_ENV['PRD_DB_HOST'],
            'name' => $_ENV['PRD_DB_NAME'],
            'user' => $_ENV['PRD_DB_USER'],
            'pass' => $_ENV['PRD_DB_PASS'],
            'port' => $_ENV['PRD_DB_PORT']??3306,
            'charset' => $_ENV['PRD_DB_CHARSET']?? 'utf8',
        ]
    ],
];
