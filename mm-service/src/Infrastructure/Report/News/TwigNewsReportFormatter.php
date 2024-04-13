<?php
declare(strict_types=1);

namespace App\Infrastructure\Report\News;

use App\Application\Report\Exception\UnsupportedReportException;
use App\Application\Report\ReportFormatter;
use App\Domain\Entity\News;
use Twig\Environment;

class TwigNewsReportFormatter extends ReportFormatter
{
    public function __construct(
        private readonly Environment $twig,
    )
    {
    }

    /**
     * @param News $data
     * @param mixed[] $context
     * @return void
     *
     * @throws UnsupportedReportException
     */
    public function checkSupports(mixed $data, array $context = []): void
    {
        if (!isset($context['template'])) {
            throw new UnsupportedReportException(
                sprintf('Context parameter "template" is required for %s formatter.', self::class),
            );
        }

        if (!is_iterable($data)) {
            $data = [$data];
        }

        foreach ($data as $item) {
            if (!$item instanceof News) {
                throw new UnsupportedReportException(
                    sprintf(
                        'Only instance of %s class as data are supported for %s formatter',
                        News::class,
                        self::class
                    )
                );
            }
        }
    }

    /**
     * @param News $data
     * @param array $context
     * @return string
     */
    protected function process(mixed $data, array $context = []): string
    {
        if (!is_iterable($data)) {
            $data = [$data];
        }

        $template = $this->twig->createTemplate($context['template']);

        return $this->twig->render($template, ['newsList' => $data]);
    }
}
