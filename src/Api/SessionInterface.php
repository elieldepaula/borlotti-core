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

interface SessionInterface
{

    /**
     * Sets the session usage in the database.
     *
     * @return void
     */
    public function useDatabaseHandler(): void;

    /**
     * Starts the session if it has not already been started.
     *
     * @return void
     */
    public function start(): void;

    /**
     * Returns the session ID.
     *
     * @param string|null $id
     * @return string
     */
    public function getId(?string $id = null): string;

    /**
     * Sets a value in the session.
     *
     * @param string $key
     * @param $value
     * @return void
     */
    public function set(string $key, $value): void;

    /**
     * Gets a value from the session. *
     * @param string $key
     * @param $default
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * Checks if a key exists in the session.
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * Removes a value from the session.
     *
     * @param string $key
     * @return void
     */
    public function forget(string $key): void;

    /**
     * Destroys the current session.
     *
     * @return void
     */
    public function destroy(): void;

    /**
     * Regenerates the session ID (prevents fixation).
     *
     * @return void
     */
    public function regenerate(): void;

    /**
     * Sets a flash message (lasts only one request). *
     * @param string $key
     * @param $value
     * @return void
     */
    public function flash(string $key, $value): void;

    /**
     * Retrieves a flash message and removes it.
     *
     * @param string $key
     * @param $default
     * @return mixed
     */
    public function getFlash(string $key, $default = null);

    /**
     * Clears all stored flash messages.
     *
     * @return void
     */
    public function clearFlash(): void;
}