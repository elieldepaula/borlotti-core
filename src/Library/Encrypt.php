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

namespace Borlotti\Core\Library;

use Borlotti\Core\Api\EncryptInterface;

class Encrypt implements EncryptInterface
{

    /**
     * @inheritDoc
     */
    public function encrypt(string $data, string $key): string
    {
        $iv = random_bytes(self::IV_LENGTH);
        $key = $this->normalizeKey($key);
        $cipherText = openssl_encrypt($data, self::CIPHER, $key, OPENSSL_RAW_DATA, $iv);

        if ($cipherText === false) {
            throw new \RuntimeException('Erro ao criptografar os dados.');
        }

        return base64_encode($iv . $cipherText);
    }

    /**
     * @inheritDoc
     */
    public function decrypt(string $encrypted, string $key): string
    {
        $decoded = base64_decode($encrypted, true);
        if ($decoded === false || strlen($decoded) < self::IV_LENGTH) {
            throw new \InvalidArgumentException('Dados criptografados inválidos.');
        }

        $iv = substr($decoded, 0, self::IV_LENGTH);
        $cipherText = substr($decoded, self::IV_LENGTH);
        $key = $this->normalizeKey($key);

        $plain = openssl_decrypt($cipherText, self::CIPHER, $key, OPENSSL_RAW_DATA, $iv);
        if ($plain === false) {
            throw new \RuntimeException('Erro ao descriptografar os dados.');
        }

        return $plain;
    }

    /**
     * @inheritDoc
     */
    public function generateKey(): string
    {
        return base64_encode(random_bytes(self::KEY_LENGTH));
    }

    /**
     * @inheritDoc
     */
    public function hash(string $data): string
    {
        return password_hash($data, PASSWORD_DEFAULT);
    }

    /**
     * @inheritDoc
     */
    public function verify(string $data, string $hash): bool
    {
        return password_verify($data, $hash);
    }

    /**
     * Normaliza a chave para 256 bits.
     */
    private function normalizeKey(string $key): string
    {
        return hash('sha256', $key, true); // true = raw binary
    }
}
