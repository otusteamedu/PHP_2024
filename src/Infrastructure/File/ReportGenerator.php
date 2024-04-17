<?php

declare(strict_types=1);

namespace App\Infrastructure\File;

use App\Application\ReportGenerator\ReportGeneratorInterface;
use App\Application\ReportGenerator\Request\ReportGeneratorRequest;
use App\Application\ReportGenerator\Response\ReportGeneratorResponse;
use Psr\Container\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

class ReportGenerator implements ReportGeneratorInterface
{
    public function __construct(
        private ContainerInterface $container,
        private KernelInterface $kernel
    ) {}

    public function generate(ReportGeneratorRequest $dto): ReportGeneratorResponse
    {
        $content = $this->container->get('twig')->render('news.html.twig', ['titles' => $dto->titles]);
        $fileSystem = new Filesystem();
        $fileSystem->dumpFile($this->kernel->getProjectDir() . '/public/uploads/news.html', $content);

        return new ReportGeneratorResponse('/uploads/news.html');
    }
}
