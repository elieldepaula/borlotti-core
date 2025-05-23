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

use Borlotti\Core\Api\JsonInterface;
use InvalidArgumentException;
use RuntimeException;
use Throwable;

/**
 * Json library.
 *
 * Usage:
 *
 * try {
 *     $json = $json->encode(['foo' => 'bar']);
 *     echo $json;
 *
 *     $array = $json->decode($json);
 *     print_r($array);
 *
 * } catch (Exception $e) {
 *     echo "Erro: " . $e->getMessage();
 * }
 *
 */
class Json implements JsonInterface
{
    /**
     * @inheritDoc
     */
    public function encode($data, int $options = 0, int $depth = 512): string
    {
        if (!$this->isSerializable($data)) {
            throw new InvalidArgumentException('The provided data is not JSON serializable.');
        }

        $json = json_encode($data, $options, $depth);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('Error encoding JSON:' . json_last_error_msg());
        }

        return $json;
    }

    /**
     * @inheritDoc
     */
    public function decode(string $json, bool $assoc = true, int $depth = 512, int $options = 0)
    {
        if (!is_string($json)) {
            throw new InvalidArgumentException('Input must be a JSON string.');
        }

        $data = json_decode($json, $assoc, $depth, $options);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('Error decoding JSON:' . json_last_error_msg());
        }

        return $data;
    }

    /**
     * Checks if the data can be serialized into JSON.
     *
     * @param mixed $data
     * @return bool
     */
    private function isSerializable($data): bool
    {
        try {
            json_encode($data, JSON_THROW_ON_ERROR);
            return true;
        } catch (Throwable $e) {
            return false;
        }
    }
}