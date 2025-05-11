<?php

declare(strict_types=1);

namespace Anatolyshilyaev\Hw14\Tests\Infrastructure\Repository;

use Anatolyshilyaev\Hw14\Application\UseCase\GetReportNews\GetReportNewsRequest;
use Anatolyshilyaev\Hw14\Domain\Entity\News;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Date;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Title;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Url;
use Anatolyshilyaev\Hw14\Infrastructure\Repository\NewsRepository;
use Anatolyshilyaev\Hw14\Infrastructure\Repository\NewsMapper;
use PHPUnit\Framework\TestCase;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use ReflectionProperty;

class NewsRepositoryTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private NewsRepository $repository;

    /** @var NewsMapper&Mockery\MockInterface */
    private $newsMapperMock;

    protected function setUp(): void
    {
        // Создаем мок NewsMapper с указанием типа
        $this->newsMapperMock = Mockery::mock(NewsMapper::class);

        // Создаем репозиторий с внедренным моком
        $this->repository = new NewsRepository($this->newsMapperMock);
    }

    public function testSaveNewsAndSetId(): void
    {
        // Arrange
        $news = new News(
            new Title('Test Title'),
            new Date(new \DateTimeImmutable()),
            new Url('https://example.com')
        );
        $expectedId = 123;

        $this->newsMapperMock->shouldReceive('save')
            ->once()
            ->with($news)
            ->andReturn($expectedId);

        // Act
        $this->repository->save($news);

        // Assert
        $reflection = new ReflectionProperty(News::class, 'id');
        $reflection->setAccessible(true);
        $this->assertEquals($expectedId, $reflection->getValue($news));
    }

    // ... остальные тестовые методы без изменений ...
}
