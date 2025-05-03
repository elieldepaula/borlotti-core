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
/**
 * Dependency injection array.
 */
return [
    \Psr\Log\LoggerInterface::class => \Borlotti\Core\Library\Logger::class,
    \Borlotti\Core\Api\JsonInterface::class => \Borlotti\Core\Library\Json::class,
    \Borlotti\Core\Api\DateInterface::class => \Borlotti\Core\Library\Date::class,
    \Borlotti\Core\Api\SessionInterface::class => \Borlotti\Core\Library\Session\Session::class,
    \Borlotti\Core\Api\EncryptInterface::class => \Borlotti\Core\Library\Encrypt::class,
];
