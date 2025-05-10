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

namespace Borlotti\Core\Library\Auth;

use Borlotti\Core\Api\Auth\AuthenticatorInterface;
use Borlotti\Core\Api\Auth\AuthManagerInterface;

class AuthManager implements AuthManagerInterface
{

    /** @var AuthenticatorInterface $authenticator */
    protected AuthenticatorInterface $authenticator;

    public function __construct(AuthenticatorInterface $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    /**
     * Get the authenticator library.
     * @return AuthenticatorInterface
     */
    public function auth(): AuthenticatorInterface
    {
        return $this->authenticator;
    }
}