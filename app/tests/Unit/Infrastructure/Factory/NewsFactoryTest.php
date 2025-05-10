<?php

namespace Anatolyshilyaev\Hw14\Tests\Infrastructure\Factory;

use Anatolyshilyaev\Hw14\Domain\Entity\News;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Date;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Title;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Url;
use Anatolyshilyaev\Hw14\Infrastructure\Factory\NewsFactory;
use PHPUnit\Framework\TestCase;

class NewsFactoryTest extends TestCase
{
    private NewsFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new NewsFactory();
    }

    public function testCreateReturnsNewsInstance(): void
    {
        // Arrange
        $title = new Title('Test Title');
        $date = new Date(new \DateTimeImmutable());
        $url = new Url('https://example.com');

        // Act
        $result = $this->factory->create($title, $date, $url);

        // Assert
        $this->assertInstanceOf(News::class, $result);
    }

    public function testCreateNewsWithCorrectValues(): void
    {
        // Arrange
        $titleText = 'Test News Title';
        $urlValue = 'https://example.com/news';
        $dateValue = new \DateTimeImmutable('2023-01-01');

        $title = new Title($titleText);
        $date = new Date($dateValue);
        $url = new Url($urlValue);

        // Act
        $news = $this->factory->create($title, $date, $url);

        // Assert
        $this->assertEquals($titleText, $news->getTitle()->getValue());
        $this->assertEquals($urlValue, $news->getUrl()->getValue());
        $this->assertEquals($dateValue, $news->getDate()->getValue());
    }

    public function testCreatedNewsIsImmutable(): void
    {
        // Arrange
        $originalDate = new \DateTimeImmutable('2023-01-01');
        $title = new Title('Title');
        $date = new Date($originalDate);
        $url = new Url('https://example.com');

        // Act
        $news = $this->factory->create($title, $date, $url);
        $modifiedDate = $news->getDate()->getValue()->modify('+1 day');

        // Assert
        $this->assertNotEquals($modifiedDate, $news->getDate()->getValue());
        $this->assertEquals('2023-01-01', $news->getDate()->getValue()->format('Y-m-d'));
    }
}
