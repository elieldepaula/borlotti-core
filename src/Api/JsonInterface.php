<?php

declare(strict_types=1);

namespace Borlotti\Core\Api;

interface JsonInterface
{

    /**
     * Converte um valor PHP para JSON com validação.
     *
     * @param mixed $data Os dados a serem convertidos para JSON.
     * @param int $options Opções de codificação (veja json_encode docs).
     * @param int $depth Profundidade máxima.
     * @return string JSON codificado.
     * @throws InvalidArgumentException Se a entrada for inválida.
     * @throws RuntimeException Se a codificação JSON falhar.
     */
    public function encode($data, int $options = 0, int $depth = 512): string;

    /**
     * Decodifica uma string JSON para PHP com validação.
     *
     * @param string $json A string JSON a ser decodificada.
     * @param bool $assoc Retornar objetos como arrays associativos.
     * @param int $depth Profundidade máxima.
     * @param int $options Opções de decodificação.
     * @return mixed Dados decodificados.
     * @throws InvalidArgumentException Se o JSON não for uma string válida.
     * @throws RuntimeException Se a decodificação falhar.
     */
    public function decode(string $json, bool $assoc = true, int $depth = 512, int $options = 0);

}