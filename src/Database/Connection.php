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

namespace Borlotti\Core\Database;

use Illuminate\Database\Capsule\Manager as Capsule;

class Connection
{
    /**
     * Initialize the database connection.
     *
     * @return void
     */
    public static function init(): void
    {
        $capsule = new Capsule();

        $connection = [
            'development' => [
                'driver' => $_ENV['DEV_DB_DRIVER'],
                'host' => $_ENV['DEV_DB_HOST'],
                'database' => $_ENV['DEV_DB_NAME'],
                'username' => $_ENV['DEV_DB_USER'],
                'password' => $_ENV['DEV_DB_PASS'],
                'port' => $_ENV['DEV_DB_PORT']??3306,
                'charset' => $_ENV['DEV_DB_CHARSET'] ?? 'utf8',
                'collation' => $_ENV['DEV_DB_COLLATION'] ?? 'utf8_unicode_ci',
                'prefix' => $_ENV['DEV_DB_PREFIX'] ?? ''
            ],
            'production' => [
                'driver' => $_ENV['PRD_DB_DRIVER'],
                'host' => $_ENV['PRD_DB_HOST'],
                'database' => $_ENV['PRD_DB_NAME'],
                'username' => $_ENV['PRD_DB_USER'],
                'password' => $_ENV['PRD_DB_PASS'],
                'port' => $_ENV['PRD_DB_PORT']??3306,
                'charset' => $_ENV['PRD_DB_CHARSET'] ?? 'utf8',
                'collation' => $_ENV['PRD_DB_COLLATION'] ?? 'utf8_unicode_ci',
                'prefix' => $_ENV['PRD_DB_PREFIX'] ?? ''
            ]
        ];

        $capsule->addConnection($connection[$_ENV['APP_ENV']]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}
