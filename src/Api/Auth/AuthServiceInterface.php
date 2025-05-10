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

namespace Borlotti\Core\Api\Auth;

interface AuthServiceInterface
{

    /**
     * Log in a user.
     * @param array $credentials
     * @return bool
     */
    public function login(array $credentials): bool;

    /**
     * Log out a user.
     * @return void
     */
    public function logout(): void;

    /**
     * Get the logged user data.
     * @return mixed
     */
    public function user();
}