<?php

namespace Anatolyshilyaev\Tests\Domain\Entity;

use Anatolyshilyaev\Hw14\Domain\Entity\News;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Title;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Date;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Url;
use PHPUnit\Framework\TestCase;

class NewsTest extends TestCase
{
    public function testCanBeCreatedWithValidData(): void
    {
        $title = new Title('Valid Title');
        $date = new Date(new \DateTimeImmutable('2025-05-10'));
        $url = new Url('https://www.example.com');

        $news = new News($title, $date, $url);

        $this->assertInstanceOf(News::class, $news);
        $this->assertEquals('Valid Title', $news->getTitle()->getValue());
        $this->assertEquals('2025-05-10', $news->getDate()->getValue()->format('Y-m-d'));
        $this->assertEquals('https://www.example.com', $news->getUrl()->getValue());
    }

    public function testGetIdReturnsNullByDefault(): void
    {
        $title = new Title('Valid Title');
        $date = new Date(new \DateTimeImmutable('2025-05-10'));
        $url = new Url('https://www.example.com');

        $news = new News($title, $date, $url);

        $this->assertNull($news->getId());
    }

    public function testCanBeCreatedWithEmptyTitle(): void
    {
        $title = new Title('');
        $date = new Date(new \DateTimeImmutable('2025-05-10'));
        $url = new Url('https://www.example.com');

        $news = new News($title, $date, $url);

        $this->assertInstanceOf(News::class, $news);
        $this->assertEquals('', $news->getTitle()->getValue());
    }

    public function testCannotBeCreatedWithEmptyUrl(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Wrong URL format');

        $title = new Title('Valid Title');
        $date = new Date(new \DateTimeImmutable('2025-05-10'));
        $url = new Url('');

        new News($title, $date, $url); // Ожидается исключение
    }
}
