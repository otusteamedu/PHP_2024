<?php

namespace Anatolyshilyaev\Hw14\Tests\Application\UseCase\FindAllNews;

use Anatolyshilyaev\Hw14\Application\UseCase\FindAllNews\FindAllNewsResponse;
use Anatolyshilyaev\Hw14\Application\UseCase\FindAllNews\FindAllNewsUseCase;
use Anatolyshilyaev\Hw14\Domain\Entity\News;
use Anatolyshilyaev\Hw14\Domain\Repository\NewsRepositoryInterface;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Date;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Title;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Url;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class FindAllNewsUseCaseTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /** @var NewsRepositoryInterface&MockInterface */
    private $newsRepository;

    private FindAllNewsUseCase $useCase;

    protected function setUp(): void
    {
        $this->newsRepository = Mockery::mock(NewsRepositoryInterface::class);
        $this->useCase = new FindAllNewsUseCase($this->newsRepository);
    }

    public function testInvokeReturnsEmptyArrayWhenNoNews(): void
    {
        // Arrange
        $this->newsRepository
            ->shouldReceive('findAll')
            ->once()
            ->andReturn([]);

        // Act
        $result = ($this->useCase)();

        // Assert
        $this->assertIsIterable($result);
        $this->assertCount(0, $result);
    }

    public function testInvokeReturnsCorrectResponseForSingleNews(): void
    {
        // Arrange
        $newsMock = $this->createNewsMock(
            'Test Title',
            'https://example.com',
            new \DateTimeImmutable('2023-01-01')
        );

        $this->newsRepository
            ->shouldReceive('findAll')
            ->once()
            ->andReturn([$newsMock]);

        // Act
        $result = ($this->useCase)();

        // Assert
        $this->assertIsIterable($result);
        $this->assertCount(1, $result);

        /** @var FindAllNewsResponse $firstResponse */
        $firstResponse = $result[0];
        $this->assertInstanceOf(FindAllNewsResponse::class, $firstResponse);
        $this->assertEquals('Test Title', $firstResponse->title);
        $this->assertEquals('https://example.com', $firstResponse->url);
        $this->assertEquals('2023-01-01', $firstResponse->date->format('Y-m-d'));
    }

    public function testInvokeReturnsCorrectResponsesForMultipleNews(): void
    {
        // Arrange
        $news1 = $this->createNewsMock(
            'Title 1',
            'https://example.com/1',
            new \DateTimeImmutable('2023-01-01')
        );

        $news2 = $this->createNewsMock(
            'Title 2',
            'https://example.com/2',
            new \DateTimeImmutable('2023-01-02')
        );

        $this->newsRepository
            ->shouldReceive('findAll')
            ->once()
            ->andReturn([$news1, $news2]);

        // Act
        $result = ($this->useCase)();

        // Assert
        $this->assertCount(2, $result);

        $this->assertEquals('Title 1', $result[0]->title);
        $this->assertEquals('https://example.com/1', $result[0]->url);

        $this->assertEquals('Title 2', $result[1]->title);
        $this->assertEquals('https://example.com/2', $result[1]->url);
    }

    private function createNewsMock(
        string $title,
        string $url,
        \DateTimeInterface $date
    ): News {
        $newsMock = Mockery::mock(News::class);
        $newsMock->shouldReceive('getTitle')
            ->andReturn(new Title($title));
        $newsMock->shouldReceive('getUrl')
            ->andReturn(new Url($url));
        $newsMock->shouldReceive('getDate')
            ->andReturn(new Date($date));

        return $newsMock;
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
