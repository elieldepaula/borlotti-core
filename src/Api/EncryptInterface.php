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

interface EncryptInterface
{
    public const CIPHER = 'AES-256-CBC';
    public const KEY_LENGTH = 32; // 256 bits
    public const IV_LENGTH = 16;  // 128 bits

    /**
     * Encrypts data.
     *
     * @param string $data Plain text data.
     * @param string $key 32-byte secret key (use hash if necessary).
     * @return string Base64 string containing IV + encrypted data.
     */
    public function encrypt(string $data, string $key): string;

    /**
     * Decrypts data.
     *
     * @param string $encrypted Base64 containing IV + encryption.
     * @param string $key C32-byte secret key.
     * @return string Plain text.
     */
    public function decrypt(string $encrypted, string $key): string;

    /**
     * Generates a secure random key (base64).
     */
    public function generateKey(): string;

    /**
     * Generates a secure hash of a string (e.g. passwords).
     */
    public function hash(string $data): string;

    /**
     * Checks if the hash matches the data.
     */
    public function verify(string $data, string $hash): bool;
}
