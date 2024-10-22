<?php

declare(strict_types=1);

namespace App\Infrastructure\Report;

use App\Application\Report\Dto\SubmitReportGeneratorRequestDto;
use App\Application\Report\Dto\SubmitReportGeneratorResponseDto;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\KernelInterface;

class FileReportGenerator implements \App\Application\Report\ReportGeneratorInterface
{
    public function __construct(
        private readonly Filesystem $filesystem,
        private readonly KernelInterface $kernel,
        private readonly RequestStack $requestStack,
    ) {
    }

    public function generate(SubmitReportGeneratorRequestDto $requestDto): SubmitReportGeneratorResponseDto
    {
        $report = '';
        if ($news = $requestDto->getNewsItems()) {
            $report = "<ul>\r\n";
            foreach ($news as $newsItem) {
                $report .= "<li><a href='{$newsItem->getUrl()->getValue()}'>{$newsItem->getTitle()->getValue()}</a></li>\r\n";
            }
            $report .= "</ul>\r\n";
        }

        $fileName = (new \DateTime())->format('dmyHis').'.html';
        $filePath = $this->kernel->getProjectDir()."/public/{$fileName}";

        $this->filesystem->touch($filePath);
        $this->filesystem->appendToFile($filePath, $report);

        $schemeAndHost = $this->requestStack->getCurrentRequest()->getSchemeAndHttpHost();
        $fileSrc = $schemeAndHost.$filePath;

        return new SubmitReportGeneratorResponseDto($fileSrc);
    }
}
