<?php

namespace Anatolyshilyaev\Hw14\Tests\Application\UseCase\CreateNews;

use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsRequest;
use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsResponse;
use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsUseCase;
use Anatolyshilyaev\Hw14\Domain\Entity\News;
use Anatolyshilyaev\Hw14\Domain\Factory\NewsFactoryInterface;
use Anatolyshilyaev\Hw14\Application\NewsParser\NewsParserInterface;
use Anatolyshilyaev\Hw14\Application\NewsParser\NewsParserRequest as ParserRequest;
use Anatolyshilyaev\Hw14\Application\NewsParser\NewsParserResponse;
use Anatolyshilyaev\Hw14\Domain\Repository\NewsRepositoryInterface;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Date;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Title;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Url;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class CreateNewsUseCaseTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /** @var NewsFactoryInterface&MockInterface */
    private $newsFactory;

    /** @var NewsParserInterface&MockInterface */
    private $newsParser;

    /** @var NewsRepositoryInterface&MockInterface */
    private $newsRepository;

    private CreateNewsUseCase $useCase;

    protected function setUp(): void
    {
        $this->newsFactory = Mockery::mock(NewsFactoryInterface::class);
        $this->newsParser = Mockery::mock(NewsParserInterface::class);
        $this->newsRepository = Mockery::mock(NewsRepositoryInterface::class);

        $this->useCase = new CreateNewsUseCase(
            $this->newsFactory,
            $this->newsParser,
            $this->newsRepository
        );
    }

    public function testInvokeCreatesAndSavesNews(): void
    {
        // Arrange
        $url = 'https://example.com/news';
        $titleText = 'Test News Title';
        $newsId = '12345';

        $request = new CreateNewsRequest($url);
        $parserResponse = new NewsParserResponse($titleText, 'Sample content');

        // Configure mocks
        $this->newsParser
            ->shouldReceive('parse')
            ->once()
            ->with(Mockery::type(ParserRequest::class))
            ->andReturn($parserResponse);

        $newsMock = Mockery::mock(News::class);
        $this->newsFactory
            ->shouldReceive('create')
            ->once()
            ->with(
                Mockery::type(Title::class),
                Mockery::type(Date::class),
                Mockery::type(Url::class)
            )
            ->andReturn($newsMock);

        $newsMock->shouldReceive('getId')->once()->andReturn($newsId);

        $this->newsRepository
            ->shouldReceive('save')
            ->once()
            ->with($newsMock);

        // Act
        $response = ($this->useCase)($request);

        // Assert
        $this->assertInstanceOf(CreateNewsResponse::class, $response);
        $this->assertEquals($newsId, $response->id);
    }


    protected function tearDown(): void
    {
        Mockery::close();
    }
}
