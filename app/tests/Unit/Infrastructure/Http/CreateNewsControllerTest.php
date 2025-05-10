<?php

declare(strict_types=1);

namespace Anatolyshilyaev\Hw14\Tests\Infrastructure\Http;

use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsRequest;
use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsResponse;
use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsUseCase;
use Anatolyshilyaev\Hw14\Infrastructure\Http\CreateNewsController;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class CreateNewsControllerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /** @var CreateNewsUseCase&MockInterface */
    private $createUseCase;

    private CreateNewsController $controller;

    protected function setUp(): void
    {
        $this->createUseCase = Mockery::mock(CreateNewsUseCase::class);
        $this->controller = new CreateNewsController($this->createUseCase);
    }

    public function testCreateReturnsResponseOnSuccess(): void
    {
        // Arrange
        $request = new CreateNewsRequest('https://example.com');
        $expectedResponse = new CreateNewsResponse(12345); // Используем int вместо string

        $this->createUseCase
            ->shouldReceive('__invoke')
            ->once()
            ->with($request)
            ->andReturn($expectedResponse);

        // Act
        $response = $this->controller->create($request);

        // Assert
        $this->assertInstanceOf(CreateNewsResponse::class, $response);
        $this->assertSame($expectedResponse, $response);
    }

    public function testCreateReturnsErrorMessageOnFailure(): void
    {
        // Arrange
        $request = new CreateNewsRequest('https://example.com');
        $errorMessage = 'Failed to create news';

        $this->createUseCase
            ->shouldReceive('__invoke')
            ->once()
            ->with($request)
            ->andThrow(new RuntimeException($errorMessage));

        // Act
        $response = $this->controller->create($request);

        // Assert
        $this->assertIsString($response);
        $this->assertEquals($errorMessage, $response);
    }

    public function testCreateHandlesDifferentExceptions(): void
    {
        // Arrange
        $request = new CreateNewsRequest('https://example.com');
        $exceptions = [
            new \InvalidArgumentException('Invalid argument'),
            new \DomainException('Domain error'),
            new \RuntimeException('Runtime error')
        ];

        foreach ($exceptions as $exception) {
            $this->createUseCase
                ->shouldReceive('__invoke')
                ->once()
                ->with($request)
                ->andThrow($exception);

            // Act
            $response = $this->controller->create($request);

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
