<?php

namespace Anatolyshilyaev\Hw14\Tests\Domain\ValueObject;

use Anatolyshilyaev\Hw14\Domain\ValueObject\Date;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class DateTest extends TestCase
{
    public function testCanBeCreatedWithDateTimeImmutable(): void
    {
        $dateTime = new DateTimeImmutable('2023-01-01');
        $date = new Date($dateTime);

        $this->assertInstanceOf(Date::class, $date);
        $this->assertSame($dateTime, $date->getValue());
    }

    public function testGetValueReturnsCorrectDateTime(): void
    {
        $dateTime = new DateTimeImmutable('2023-12-31 23:59:59');
        $date = new Date($dateTime);

        $this->assertSame($dateTime, $date->getValue());
    }

    public function testDateIsImmutable(): void
    {
        $originalDate = new DateTimeImmutable('2023-06-15');
        $date = new Date($originalDate);

        // Попытка "изменить" дату (должно остаться неизменным)
        $modifiedDate = $date->getValue()->modify('+1 day');

        $this->assertNotSame($modifiedDate, $date->getValue());
        $this->assertEquals('2023-06-15', $date->getValue()->format('Y-m-d'));
    }

    public function testEqualsReturnsTrueForSameDate(): void
    {
        $date1 = new Date(new DateTimeImmutable('2023-05-20'));
        $date2 = new Date(new DateTimeImmutable('2023-05-20'));

        $this->assertTrue($date1->getValue() == $date2->getValue());
    }

    public function testEqualsReturnsFalseForDifferentDates(): void
    {
        $date1 = new Date(new DateTimeImmutable('2023-05-20'));
        $date2 = new Date(new DateTimeImmutable('2023-05-21'));

        $this->assertFalse($date1->getValue() == $date2->getValue());
    }
}
