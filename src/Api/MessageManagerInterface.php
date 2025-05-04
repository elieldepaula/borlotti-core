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

namespace Borlotti\Core\Api;

interface MessageManagerInterface
{

    /**
     * Set a flash message.
     *
     * @param string $type 'success', 'danger', 'info', 'warning'
     * @param string $message
     * @return bool
     */
    public function setFlashMessage(string $type, string $message): bool;

    /**
     * Get a flash message.
     *
     * @return array
     */
    public function getFlashMessage(): ?array;

}