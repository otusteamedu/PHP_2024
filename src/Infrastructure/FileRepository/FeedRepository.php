<?php

namespace App\Infrastructure\FileRepository;

use App\Domain\Entity\Feed;
use App\Domain\Repository\FeedFileRepositoryInterface;
use Symfony\Component\Filesystem\Filesystem;

readonly class FeedRepository implements FeedFileRepositoryInterface
{
    public function __construct(
        private string $reportsDir,
    ) {
    }

    /**
     * @param Feed[] $feeds
     */
    public function saveReport(array $feeds): string
    {
        $html = '<ul>' . PHP_EOL;
        foreach ($feeds as $feed) {
            /** @noinspection HtmlUnknownTarget */
            $html .= sprintf('<li><a href="%s">%s</a></li>', $feed->getUrl()->getValue(), $feed->getTitle()->getValue()) . PHP_EOL;
        }
        $html .= '</ul>';

        $fileName = 'report_' . time() . '.html';
        $filePath = $this->reportsDir . '/' . $fileName;
        $filesystem = new Filesystem();
        $filesystem->mkdir($this->reportsDir);
        $filesystem->dumpFile($filePath, $html);

        return $fileName;
    }
}
