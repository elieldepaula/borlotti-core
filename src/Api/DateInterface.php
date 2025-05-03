<?php

declare(strict_types=1);

namespace Borlotti\Core\Api;

use DateInterval;
use DateTime;
use IntlDateFormatter;

interface DateInterface
{

    /**
     * Retorna o horário atual como DateTime.
     */
    public function now(?string $timezone = null): DateTime;

    /**
     * Converte uma data de um formato para outro.
     */
    public function convertFormat(string $date, string $fromFormat, string $toFormat): string;

    /**
     * Verifica se a data é válida segundo um formato.
     */
    public function isValidDate(string $date, string $format = 'Y-m-d'): bool;

    /**
     * Calcula a diferença entre duas datas.
     */
    public function difference($date1, $date2): DateInterval;

    /**
     * Adiciona um intervalo de tempo a uma data.
     */
    public function add($date, string $intervalStr): DateTime;

    /**
     * Subtrai um intervalo de tempo de uma data.
     */
    public function subtract($date, string $intervalStr): DateTime;

    /**
     * Converte timestamp Unix para DateTime.
     */
    public function fromTimestamp(int $timestamp, ?string $timezone = null): DateTime;

    /**
     * Converte DateTime ou string para timestamp Unix.
     */
    public function toTimestamp($date): int;

    /**
     * Formata uma data segundo a localidade.
     */
    public function formatLocalized($date, string $locale = 'pt_BR', int $dateType = IntlDateFormatter::LONG, int $timeType = IntlDateFormatter::SHORT, ?string $timezone = null): string;
}