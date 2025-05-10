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

use Borlotti\Core\Api\Auth\AuthManagerInterface;
use Borlotti\Core\Api\Auth\AuthServiceInterface;

class AuthService implements AuthServiceInterface
{

    /** @var AuthManagerInterface $manager */
    protected AuthManagerInterface $manager;

    public function __construct(AuthManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @inheritDoc
     */
    public function login(array $credentials): bool
    {
        return $this->manager->auth()->attempt($credentials);
    }

    /**
     * @inheritDoc
     */
    public function logout(): void
    {
        $this->manager->auth()->logout();
    }

    /**
     * @inheritDoc
     */
    public function user()
    {
        return $this->manager->auth()->user();
    }

    /**
     * @inheritDoc
     */
    public function isLogged(): bool
    {
        return $this->manager->auth()->isLogged();
    }
}