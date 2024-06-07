<?php

declare(strict_types=1);

namespace App;

use App\Application\Gateway\ArticleParserInterface;
use App\Application\Helper\NewsTitleExtractorInterface;
use App\Application\Helper\ReportGeneratorInterface;
use App\Application\UseCase\CreateNewsUseCase;
use App\Application\UseCase\GenerateReportUseCase;
use App\Application\UseCase\GetAllNewsUseCase;
use App\Application\Validator\CreateNewsValidatorInterface;
use App\Application\Validator\CreateNewsValidator;
use App\Application\Validator\GenerateReportValidator;
use App\Application\Validator\GenerateReportValidatorInterface;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Infrastructure\Gateway\HttpArticleParser;
use App\Infrastructure\Helper\NewsTitleExtractor;
use App\Infrastructure\Helper\ReportGenerator;
use App\Infrastructure\Middleware\CreateNewsRequestMiddleware;
use App\Infrastructure\Middleware\GenerateReportRequestMiddleware;
use App\Infrastructure\Repository\NewsRepository;
use DI\ContainerBuilder;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;

class Container
{
    public static function build(): ContainerInterface
    {
        $containerBuilder = new ContainerBuilder();

        $containerBuilder->addDefinitions([
            EntityManager::class => static function () {
                return require __DIR__ . '/../config/doctrine.php';
            },
            ArticleParserInterface::class => static fn() => new HttpArticleParser(new Client()),
            NewsTitleExtractorInterface::class => static fn() => new NewsTitleExtractor(),
            CreateNewsValidatorInterface::class => static fn() => new CreateNewsValidator(),
            GenerateReportValidatorInterface::class => static fn() => new GenerateReportValidator(),
            ReportGeneratorInterface::class => static fn() => new ReportGenerator(getenv('URL')),
            NewsRepositoryInterface::class => static fn(ContainerInterface $container) => new NewsRepository(
                $container->get(EntityManager::class)
            ),
            CreateNewsRequestMiddleware::class => static fn(ContainerInterface $container
            ) => new CreateNewsRequestMiddleware($container),
            GenerateReportRequestMiddleware::class => static fn(ContainerInterface $container
            ) => new GenerateReportRequestMiddleware($container),
            CreateNewsUseCase::class => static fn(ContainerInterface $container) => new CreateNewsUseCase(
                $container->get(ArticleParserInterface::class),
                $container->get(NewsRepositoryInterface::class),
                $container->get(NewsTitleExtractorInterface::class),
                $container->get(CreateNewsValidatorInterface::class),
            ),
            GetAllNewsUseCase::class => static fn(ContainerInterface $container) => new GetAllNewsUseCase(
                $container->get(NewsRepositoryInterface::class),
            ),
            GenerateReportUseCase::class => static fn(ContainerInterface $container) => new GenerateReportUseCase(
                $container->get(NewsRepositoryInterface::class),
                $container->get(ReportGeneratorInterface::class),
                $container->get(GenerateReportValidatorInterface::class),
            ),
        ]);


        return $containerBuilder->build();
    }
}
