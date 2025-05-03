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

use Borlotti\Core\Api\DateInterface;
use DateInterval;
use DateTime;
use DateTimeZone;
use IntlDateFormatter;
use InvalidArgumentException;

class Date implements DateInterface
{
    /**
     * @inheritDoc
     */
    public function now(?string $timezone = null): DateTime
    {
        return new DateTime('now', $timezone ? new DateTimeZone($timezone) : null);
    }

    /**
     * @inheritDoc
     */
    public function convertFormat(string $date, string $fromFormat, string $toFormat): string
    {
        $dt = DateTime::createFromFormat($fromFormat, $date);
        if (!$dt) {
            throw new InvalidArgumentException("Data inválida ou formato incorreto: {$date}");
        }
        return $dt->format($toFormat);
    }

    /**
     * @inheritDoc
     */
    public function isValidDate(string $date, string $format = 'Y-m-d'): bool
    {
        $dt = DateTime::createFromFormat($format, $date);
        return $dt && $dt->format($format) === $date;
    }

    /**
     * @inheritDoc
     */
    public function difference($date1, $date2): DateInterval
    {
        $d1 = self::toDateTime($date1);
        $d2 = self::toDateTime($date2);
        return $d1->diff($d2);
    }

    /**
     * @inheritDoc
     */
    public function add($date, string $intervalStr): DateTime
    {
        $dt = self::toDateTime($date);
        return $dt->add(new DateInterval($intervalStr));
    }

    /**
     * @inheritDoc
     */
    public function subtract($date, string $intervalStr): DateTime
    {
        $dt = self::toDateTime($date);
        return $dt->sub(new DateInterval($intervalStr));
    }

    /**
     * @inheritDoc
     */
    public function fromTimestamp(int $timestamp, ?string $timezone = null): DateTime
    {
        $dt = new DateTime("@$timestamp");
        if ($timezone) {
            $dt->setTimezone(new DateTimeZone($timezone));
        }
        return $dt;
    }

    /**
     * @inheritDoc
     */
    public function toTimestamp($date): int
    {
        $dt = self::toDateTime($date);
        return $dt->getTimestamp();
    }

    /**
     * @inheritDoc
     */
    public function formatLocalized($date, string $locale = 'pt_BR', int $dateType = IntlDateFormatter::LONG, int $timeType = IntlDateFormatter::SHORT, ?string $timezone = null): string
    {
        if (!class_exists('IntlDateFormatter')) {
            throw new RuntimeException('Intl extension não está disponível.');
        }

        $dt = self::toDateTime($date);
        $formatter = new IntlDateFormatter(
            $locale,
            $dateType,
            $timeType,
            $timezone ?: $dt->getTimezone()->getName()
        );
        return $formatter->format($dt);
    }

    /**
     * Converte para DateTime seguro.
     */
    private function toDateTime($input): DateTime
    {
        if ($input instanceof DateTime) {
            return clone $input;
        }

        if (is_numeric($input)) {
            return self::fromTimestamp((int)$input);
        }

        if (is_string($input)) {
            $dt = new DateTime($input);
            if (!$dt) {
                throw new InvalidArgumentException("Data inválida: $input");
            }
            return $dt;
        }

        throw new InvalidArgumentException('Valor inválido para data.');
    }
}