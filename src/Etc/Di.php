<?php

declare(strict_types=1);

return [
    \Psr\Log\LoggerInterface::class => \Borlotti\Core\Library\Logger::class,
    \Borlotti\Core\Api\JsonInterface::class => \Borlotti\Core\Library\Json::class,
    \Borlotti\Core\Api\DateInterface::class => \Borlotti\Core\Library\Date::class,
    \Borlotti\Core\Api\SessionInterface::class => \Borlotti\Core\Library\Session\Session::class,
    \Borlotti\Core\Api\EncryptInterface::class => \Borlotti\Core\Library\Encrypt::class,
];
