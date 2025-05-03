<?php

declare(strict_types=1);

namespace Borlotti\Core\Api;

interface EncryptInterface
{
    public const CIPHER = 'AES-256-CBC';
    public const KEY_LENGTH = 32; // 256 bits
    public const IV_LENGTH = 16;  // 128 bits

    /**
     * Criptografa um dado.
     *
     * @param string $data Dados em texto.
     * @param string $key Chave secreta de 32 bytes (use hash se necessário).
     * @return string Base64 contendo IV + dados criptografados.
     */
    public function encrypt(string $data, string $key): string;

    /**
     * Descriptografa os dados.
     *
     * @param string $encrypted Base64 contendo IV + criptografia.
     * @param string $key Chave secreta de 32 bytes.
     * @return string Texto original.
     */
    public function decrypt(string $encrypted, string $key): string;

    /**
     * Gera uma chave segura aleatória (base64).
     */
    public function generateKey(): string;

    /**
     * Gera um hash seguro de uma string (por exemplo, senhas).
     */
    public function hash(string $data): string;

    /**
     * Verifica se o hash bate com os dados.
     */
    public function verify(string $data, string $hash): bool;
}
