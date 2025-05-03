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

namespace Borlotti\Core\Library\Session;

use Borlotti\Core\Api\SessionInterface;

class Session implements SessionInterface
{

    public function useDatabaseHandler(): void
    {
        $handler = new DatabaseSessionHandler();
        session_set_save_handler($handler, true);
    }

    /**
     * @inheritDoc
     */
    public function start(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    /**
     * @inheritDoc
     */
    public function getId(?string $id = null): string
    {
        self::start();
        return session_id($id);
    }

    /**
     * @inheritDoc
     */
    public function set(string $key, $value): void
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    /**
     * @inheritDoc
     */
    public function get(string $key, $default = null)
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    /**
     * @inheritDoc
     */
    public function has(string $key): bool
    {
        self::start();
        return array_key_exists($key, $_SESSION);
    }

    /**
     * @inheritDoc
     */
    public function forget(string $key): void
    {
        self::start();
        unset($_SESSION[$key]);
    }

    /**
     * @inheritDoc
     */
    public function destroy(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION = [];
            session_unset();
            session_destroy();
        }
    }

    /**
     * @inheritDoc
     */
    public function regenerate(): void
    {
        self::start();
        session_regenerate_id(true);
    }

    /**
     * @inheritDoc
     */
    public function flash(string $key, $value): void
    {
        self::start();
        $_SESSION['_flash'][$key] = $value;
    }

    /**
     * @inheritDoc
     */
    public function getFlash(string $key, $default = null)
    {
        self::start();
        $value = $_SESSION['_flash'][$key] ?? $default;
        unset($_SESSION['_flash'][$key]);
        return $value;
    }

    /**
     * @inheritDoc
     */
    public function clearFlash(): void
    {
        self::start();
        unset($_SESSION['_flash']);
    }
}