<?php

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

        $capsule->addConnection([
            'driver' => $_ENV['DB_DRIVER'],
            'host' => $_ENV['DB_HOST'],
            'database' => $_ENV['DB_NAME'],
            'username' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASS'],
            'charset' => $_ENV['DB_CHARSET']?? 'utf8',
            'collation' => $_ENV['DB_COLLATION']?? 'utf8_unicode_ci',
            'prefix' => $_ENV['DB_PREFIX']??'',
            'port' => $_ENV['DB_PORT']??3306,
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}
