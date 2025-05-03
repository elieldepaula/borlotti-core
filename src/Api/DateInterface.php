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

use DateInterval;
use DateTime;
use IntlDateFormatter;

interface DateInterface
{

    /**
     * Returns the current time as a DateTime.
     */
    public function now(?string $timezone = null): DateTime;

    /**
     * Converts a date from one format to another.
     */
    public function convertFormat(string $date, string $fromFormat, string $toFormat): string;

    /**
     * Checks if the date is valid according to a format.
     */
    public function isValidDate(string $date, string $format = 'Y-m-d'): bool;

    /**
     * Calculates the difference between two dates.
     */
    public function difference($date1, $date2): DateInterval;

    /**
     * Adds a time interval to a date.
     */
    public function add($date, string $intervalStr): DateTime;

    /**
     * Subtracts a time interval from a date.
     */
    public function subtract($date, string $intervalStr): DateTime;

    /**
     * Converts Unix timestamp to DateTime.
     */
    public function fromTimestamp(int $timestamp, ?string $timezone = null): DateTime;

    /**
     * Converts DateTime or string to Unix timestamp.
     */
    public function toTimestamp($date): int;

    /**
     * Formats a date according to the location.
     */
    public function formatLocalized(
        $date,
        string $locale = 'pt_BR',
        int $dateType = IntlDateFormatter::LONG,
        int $timeType = IntlDateFormatter::SHORT,
        ?string $timezone = null): string;
}