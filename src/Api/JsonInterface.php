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

interface JsonInterface
{

    /**
     * Converts a PHP value to JSON with validation.
     *
     * @param mixed $data The data to convert to JSON.
     * @param int $options Encoding options (see json_encode docs).
     * @param int $depth Maximum depth.
     * @return string JSON encoded string.
     * @throws InvalidArgumentException If the input is invalid.
     * @throws RuntimeException If JSON encoding fails.
     */
    public function encode($data, int $options = 0, int $depth = 512): string;

    /**
     * Decodes a JSON string to PHP with validation.
     *
     * @param string $json The JSON string to decode.
     * @param bool $assoc Return objects as associative arrays.
     * @param int $depth Maximum depth. * @param int $options Decode options.
     * @return mixed Decoded data.
     * @throws InvalidArgumentException If the JSON is not a valid string.
     * @throws RuntimeException If decoding fails.
     */
    public function decode(string $json, bool $assoc = true, int $depth = 512, int $options = 0);

}