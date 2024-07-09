<?php

declare(strict_types=1);

namespace App\Infrastructure\Report;

use App\Application\ReportGenerator\ReportGeneratorInterface;
use App\Application\ReportGenerator\Request\ReportGeneratorRequest;
use Psr\Container\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

class Generator implements ReportGeneratorInterface
{
    public function __construct(
        private ContainerInterface $container,
        private KernelInterface $kernel
    ) {}

    public function generate(ReportGeneratorRequest $dto): void
    {
        $content = $this->container->get('twig')->render('news.html.twig', ['titles' => $dto->titles]);
        $fileSystem = new Filesystem();
        $fileSystem->dumpFile($this->kernel->getProjectDir() . '/public/uploads/news.html', $content);
    }
}
