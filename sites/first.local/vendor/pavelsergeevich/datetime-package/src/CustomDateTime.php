<?php

declare(strict_types=1); //Строгая типизация

namespace Pavelsergeevich\DatetimePackage;

use \DateTime;

/**
 * Класс расширяющий возможности стандартного \DateTime с полной обратной совместимостью обьектов и методов
 */
class CustomDateTime extends DateTime
{
    public const FORMAT_DEFAULT = 'Y-m-d';
    public const FORMAT_MYSQL = 'Y-m-d H:i:s';

    /**
     * Получить строку начало недели в указанном формате
     * @param string|null $format формат даты, по умолчанию "Y-m-d"
     * @return string Строка даты-времени в указанном формате
     */
    public function getStartWeek(?string $format = self::FORMAT_DEFAULT): string
    {
        return date($format, strtotime('monday this week', $this->getTimestamp()));
    }
}


