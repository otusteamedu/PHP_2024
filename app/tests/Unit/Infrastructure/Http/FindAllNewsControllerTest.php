<?php

declare(strict_types=1);

namespace Anatolyshilyaev\Hw14\Tests\Infrastructure\Http;

use Anatolyshilyaev\Hw14\Application\UseCase\FindAllNews\FindAllNewsUseCase;
use Anatolyshilyaev\Hw14\Application\UseCase\FindAllNews\FindAllNewsResponse;
use Anatolyshilyaev\Hw14\Infrastructure\Http\FindAllNewsController;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class FindAllNewsControllerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /** @var FindAllNewsUseCase&MockInterface */
    private $findAllUseCase;

    private FindAllNewsController $controller;

    protected function setUp(): void
    {
        $this->findAllUseCase = Mockery::mock(FindAllNewsUseCase::class);
        $this->controller = new FindAllNewsController($this->findAllUseCase);
    }

    public function testFindAllReturnsResponseOnSuccess(): void
    {
        // Arrange
        $expectedResponses = [
            new FindAllNewsResponse('Title 1', 'https://example.com/1', new \DateTimeImmutable('2023-01-01')),
            new FindAllNewsResponse('Title 2', 'https://example.com/2', new \DateTimeImmutable('2023-01-02'))
        ];

        $this->findAllUseCase
            ->shouldReceive('__invoke')
            ->once()
            ->andReturn($expectedResponses);

        // Act
        $response = $this->controller->findAll();

        // Assert
        $this->assertIsIterable($response);
        $this->assertEquals($expectedResponses, $response);
    }

    public function testFindAllReturnsEmptyArrayWhenNoNews(): void
    {
        // Arrange
        $this->findAllUseCase
            ->shouldReceive('__invoke')
            ->once()
            ->andReturn([]);

        // Act
        $response = $this->controller->findAll();

        // Assert
        $this->assertIsIterable($response);
        $this->assertCount(0, $response);
    }

    public function testFindAllReturnsErrorMessageOnFailure(): void
    {
        // Arrange
        $errorMessage = 'Failed to fetch news';

        $this->findAllUseCase
            ->shouldReceive('__invoke')
            ->once()
            ->andThrow(new RuntimeException($errorMessage));

        // Act
        $response = $this->controller->findAll();

        // Assert
        $this->assertIsString($response);
        $this->assertEquals($errorMessage, $response);
    }

    public function testFindAllHandlesDifferentExceptions(): void
    {
        // Arrange
        $exceptions = [
            new \InvalidArgumentException('Invalid argument'),
            new \DomainException('Domain error'),
            new \RuntimeException('Runtime error')
        ];

        foreach ($exceptions as $exception) {
            $this->findAllUseCase
                ->shouldReceive('__invoke')
                ->once()
                ->andThrow($exception);

            // Act
            $response = $this->controller->findAll();

            // Assert
            $this->assertIsString($response);
            $this->assertEquals($exception->getMessage(), $response);
        }
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
