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
     * Define o uso da sessão em banco de dados.
     *
     * @return void
     */
    public function useDatabaseHandler(): void;

    /**
     * Inicia a sessão se ainda não tiver sido iniciada.
     *
     * @return void
     */
    public function start(): void;

    /**
     * Retorna o ID da sessão.
     *
     * @param string|null $id
     * @return string
     */
    public function getId(?string $id = null): string;

    /**
     * Define um valor na sessão.
     *
     * @param string $key
     * @param $value
     * @return void
     */
    public function set(string $key, $value): void;

    /**
     * Obtém um valor da sessão.
     *
     * @param string $key
     * @param $default
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * Verifica se existe uma chave na sessão.
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * Remove um valor da sessão.
     *
     * @param string $key
     * @return void
     */
    public function forget(string $key): void;

    /**
     * Destrói a sessão atual.
     *
     * @return void
     */
    public function destroy(): void;

    /**
     * Regenera o ID da sessão (evita fixation).
     *
     * @return void
     */
    public function regenerate(): void;

    /**
     * Define uma mensagem flash (dura apenas uma requisição).
     *
     * @param string $key
     * @param $value
     * @return void
     */
    public function flash(string $key, $value): void;

    /**
     * Recupera uma mensagem flash e a remove.
     *
     * @param string $key
     * @param $default
     * @return mixed
     */
    public function getFlash(string $key, $default = null);

    /**
     * Limpa todas as flash messages armazenadas.
     *
     * @return void
     */
    public function clearFlash(): void;
}