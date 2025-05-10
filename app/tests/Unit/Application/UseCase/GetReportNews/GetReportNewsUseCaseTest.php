<?php

namespace Anatolyshilyaev\Hw14\Tests\Application\UseCase\GetReportNews;

use Anatolyshilyaev\Hw14\Application\ReportGenerator\ReportGeneratorInterface;
use Anatolyshilyaev\Hw14\Application\ReportGenerator\ReportGeneratorRequest;
use Anatolyshilyaev\Hw14\Application\ReportGenerator\ReportGeneratorResponse;
use Anatolyshilyaev\Hw14\Application\UseCase\GetReportNews\GetReportNewsRequest;
use Anatolyshilyaev\Hw14\Application\UseCase\GetReportNews\GetReportNewsResponse;
use Anatolyshilyaev\Hw14\Application\UseCase\GetReportNews\GetReportNewsUseCase;
use Anatolyshilyaev\Hw14\Domain\Entity\News;
use Anatolyshilyaev\Hw14\Domain\Repository\NewsRepositoryInterface;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Title;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Url;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class GetReportNewsUseCaseTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /** @var NewsRepositoryInterface&MockInterface */
    private $newsRepository;

    /** @var ReportGeneratorInterface&MockInterface */
    private $reportGenerator;

    private GetReportNewsUseCase $useCase;

    protected function setUp(): void
    {
        $this->newsRepository = Mockery::mock(NewsRepositoryInterface::class);
        $this->reportGenerator = Mockery::mock(ReportGeneratorInterface::class);
        $this->useCase = new GetReportNewsUseCase(
            $this->newsRepository,
            $this->reportGenerator
        );
    }

    public function testInvokeGeneratesReportForSingleNews(): void
    {
        // Arrange
        $request = new GetReportNewsRequest([1]);
        $expectedFilename = 'report_2023.csv';

        $newsMock = $this->createNewsMock('Test Title', 'https://example.com');

        $this->newsRepository
            ->shouldReceive('findByIds')
            ->once()
            ->with($request)
            ->andReturn([$newsMock]);

        $this->reportGenerator
            ->shouldReceive('generate')
            ->once()
            ->with(Mockery::on(function ($requests) {
                return count($requests) === 1
                    && $requests[0] instanceof ReportGeneratorRequest
                    && $requests[0]->title === 'Test Title'
                    && $requests[0]->url === 'https://example.com';
            }))
            ->andReturn(new ReportGeneratorResponse($expectedFilename));

        // Act
        $response = ($this->useCase)($request);

        // Assert
        $this->assertInstanceOf(GetReportNewsResponse::class, $response);
        $this->assertEquals($expectedFilename, $response->filename);
    }

    public function testInvokeGeneratesReportForMultipleNews(): void
    {
        // Arrange
        $request = new GetReportNewsRequest([1, 2, 3]);
        $expectedFilename = 'multi_report.csv';

        $news1 = $this->createNewsMock('Title 1', 'https://example.com/1');
        $news2 = $this->createNewsMock('Title 2', 'https://example.com/2');

        $this->newsRepository
            ->shouldReceive('findByIds')
            ->once()
            ->with($request)
            ->andReturn([$news1, $news2]);

        $this->reportGenerator
            ->shouldReceive('generate')
            ->once()
            ->with(Mockery::on(function ($requests) {
                return count($requests) === 2
                    && $requests[0]->title === 'Title 1'
                    && $requests[1]->title === 'Title 2';
            }))
            ->andReturn(new ReportGeneratorResponse($expectedFilename));

        // Act
        $response = ($this->useCase)($request);

        // Assert
        $this->assertEquals($expectedFilename, $response->filename);
    }

    public function testInvokeHandlesEmptyNewsList(): void
    {
        // Arrange
        $request = new GetReportNewsRequest([999]);
        $expectedFilename = 'empty_report.csv';

        $this->newsRepository
            ->shouldReceive('findByIds')
            ->once()
            ->with($request)
            ->andReturn([]);

        $this->reportGenerator
            ->shouldReceive('generate')
            ->once()
            ->with([])
            ->andReturn(new ReportGeneratorResponse($expectedFilename));

        // Act
        $response = ($this->useCase)($request);

        // Assert
        $this->assertEquals($expectedFilename, $response->filename);
    }

    public function testThrowsExceptionWhenGeneratorFails(): void
    {
        // Arrange
        $request = new GetReportNewsRequest([1]);
        $newsMock = $this->createNewsMock('Test', 'https://test.com');

        $this->newsRepository
            ->shouldReceive('findByIds')
            ->andReturn([$newsMock]);

        $this->reportGenerator
            ->shouldReceive('generate')
            ->andThrow(new \RuntimeException('Generation failed'));

        // Assert
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Generation failed');

        // Act
        ($this->useCase)($request);
    }

    private function createNewsMock(string $title, string $url): News
    {
        $newsMock = Mockery::mock(News::class);
        $newsMock->shouldReceive('getTitle')
            ->andReturn(new Title($title));
        $newsMock->shouldReceive('getUrl')
            ->andReturn(new Url($url));

        return $newsMock;
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
