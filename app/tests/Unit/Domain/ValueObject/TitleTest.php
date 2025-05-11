<?php

namespace Anatolyshilyaev\Hw14\Tests\Domain\ValueObject;

use Anatolyshilyaev\Hw14\Domain\ValueObject\Title;
use PHPUnit\Framework\TestCase;

class TitleTest extends TestCase
{
    /**
     * @covers \Anatolyshilyaev\Hw14\Domain\ValueObject\Title
     */
    public function testCanBeCreatedWithValidTitle(): void
    {
        // Тестирование корректного создания с допустимым заголовком
        $title = new Title('Valid Title');

        $this->assertInstanceOf(Title::class, $title);
        $this->assertSame('Valid Title', $title->getValue());
    }

    public function testThrowsExceptionForTitleLongerThan255Characters(): void
    {
        // Тестирование исключения, если заголовок слишком длинный
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Title must be less thab 255 characters long');

        // Заголовок длиной больше 255 символов
        $longTitle = str_repeat('a', 256);
        new Title($longTitle);
    }

    public function testGetValueReturnsCorrectTitle(): void
    {
        // Проверка, что getValue() возвращает правильное значение
        $title = new Title('Test Title');

        $this->assertSame('Test Title', $title->getValue());
    }
}
