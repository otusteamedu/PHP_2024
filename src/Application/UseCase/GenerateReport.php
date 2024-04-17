<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Domain\Repository\NewsInterface;
use App\Application\UseCase\Response\GenerateReportResponse;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GenerateReport
{
    public function __construct(
        private ContainerInterface $container,
        private KernelInterface $kernel,
        private ParameterBagInterface $params,
        private NewsInterface $newsRepository
    ) {}

    public function __invoke(array $ids): GenerateReportResponse
    {
        $titles = $this->newsRepository->getTitles($ids);
        $content = $this->container->get('twig')->render('news.html.twig', ['titles' => $titles]);
        $fileSystem = new Filesystem();
        $fileSystem->dumpFile($this->kernel->getProjectDir() . '/public/uploads/news.html', $content);

        return new GenerateReportResponse($this->params->get('app.base_url') . '/uploads/news.html');
    }
}
