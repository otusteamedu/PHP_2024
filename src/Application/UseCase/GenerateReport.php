<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Domain\Entity\News;
use App\Domain\Repository\NewsInterface;
use App\Domain\File\FileSystemInterface;
use App\Application\UseCase\Response\GenerateReportResponse;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GenerateReport
{
    public function __construct(
        private ContainerInterface $container,
        private KernelInterface $kernel,
        private ParameterBagInterface $params,
        private NewsInterface $newsRepository,
        private FileSystemInterface $fileSystem
    ) {}

    public function __invoke(array $ids): GenerateReportResponse
    {
        $news = $this->newsRepository->findBy([
            'id' => $ids
        ]);
        $titles = array_map(fn(News $item) => $item->getTitle(), $news);
        $content = $this->container->get('twig')->render('news.html.twig', ['titles' => $titles]);

        $this->fileSystem->dump($this->kernel->getProjectDir() . '/public/uploads/news.html', $content);

        return new GenerateReportResponse($this->params->get('app.base_url') . '/uploads/news.html');
    }
}
