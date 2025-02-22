<?php

namespace App\Infrastructure\Service\Report;

use App\Application\GeneratorReport\ReportGeneratorInterface;
use App\Application\GeneratorReport\ReportGeneratorRequest;
use App\Application\GeneratorReport\ReportGeneratorResponse;
use Symfony\Component\Filesystem\Filesystem;

readonly class Generator implements ReportGeneratorInterface
{
    public function __construct(
        private string $reportsDir,
    ) {
    }

    /**
     * @param ReportGeneratorRequest[] $feeds
     */
    public function generateReport(array $feeds): ReportGeneratorResponse
    {
        $html = '<ul>' . PHP_EOL;
        foreach ($feeds as $feed) {
            /** @noinspection HtmlUnknownTarget */
            $html .= sprintf('<li><a href="%s">%s</a></li>', $feed->url->getValue(), $feed->title->getValue()) . PHP_EOL;
        }
        $html .= '</ul>';

        $fileName = 'report_' . time() . '.html';
        $filePath = $this->reportsDir . '/' . $fileName;
        $filesystem = new Filesystem();
        $filesystem->mkdir($this->reportsDir);
        $filesystem->dumpFile($filePath, $html);

        return new ReportGeneratorResponse($fileName);
    }
}
