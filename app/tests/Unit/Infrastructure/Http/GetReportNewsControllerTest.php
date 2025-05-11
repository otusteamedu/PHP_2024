<?php

declare(strict_types=1);

namespace Anatolyshilyaev\Hw14\Tests\Infrastructure\Http;

use Anatolyshilyaev\Hw14\Application\UseCase\GetReportNews\GetReportNewsRequest;
use Anatolyshilyaev\Hw14\Application\UseCase\GetReportNews\GetReportNewsResponse;
use Anatolyshilyaev\Hw14\Application\UseCase\GetReportNews\GetReportNewsUseCase;
use Anatolyshilyaev\Hw14\Infrastructure\Http\GetReportNewsController;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class GetReportNewsControllerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /** @var GetReportNewsUseCase&MockInterface */
    private $getReportUseCase;

    private GetReportNewsController $controller;

    protected function setUp(): void
    {
        $this->getReportUseCase = Mockery::mock(GetReportNewsUseCase::class);
        $this->controller = new GetReportNewsController($this->getReportUseCase);
    }

    public function testGetReportReturnsResponseOnSuccess(): void
    {
        // Arrange
        $request = new GetReportNewsRequest([1, 2, 3]);
        $expectedResponse = new GetReportNewsResponse('report_123.csv');

        $this->getReportUseCase
            ->shouldReceive('__invoke')
            ->once()
            ->with($request)
            ->andReturn($expectedResponse);

        // Act
        $response = $this->controller->getReport($request);

        // Assert
        $this->assertInstanceOf(GetReportNewsResponse::class, $response);
        $this->assertSame($expectedResponse, $response);
    }

    public function testGetReportReturnsErrorMessageOnFailure(): void
    {
        // Arrange
        $request = new GetReportNewsRequest([1]);
        $errorMessage = 'Failed to generate report';

        $this->getReportUseCase
            ->shouldReceive('__invoke')
            ->once()
            ->with($request)
            ->andThrow(new RuntimeException($errorMessage));

        // Act
        $response = $this->controller->getReport($request);

        // Assert
        $this->assertIsString($response);
        $this->assertEquals($errorMessage, $response);
    }

    public function testGetReportHandlesEmptyRequest(): void
    {
        // Arrange
        $request = new GetReportNewsRequest([]);
        $expectedResponse = new GetReportNewsResponse('empty_report.csv');

        $this->getReportUseCase
            ->shouldReceive('__invoke')
            ->once()
            ->with($request)
            ->andReturn($expectedResponse);

        // Act
        $response = $this->controller->getReport($request);

        // Assert
        $this->assertInstanceOf(GetReportNewsResponse::class, $response);
        $this->assertEquals('empty_report.csv', $response->filename);
    }

    public function testGetReportHandlesDifferentExceptions(): void
    {
        // Arrange
        $request = new GetReportNewsRequest([1]);
        $exceptions = [
            new \InvalidArgumentException('Invalid argument'),
            new \DomainException('Domain error'),
            new \RuntimeException('Runtime error')
        ];

        foreach ($exceptions as $exception) {
            $this->getReportUseCase
                ->shouldReceive('__invoke')
                ->once()
                ->with($request)
                ->andThrow($exception);

            // Act
            $response = $this->controller->getReport($request);

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
