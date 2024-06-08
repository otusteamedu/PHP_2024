<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Application\Dto\NewsReportDto;
use App\Application\Service\NewsReportGeneratorInterface;
use App\Domain\Entity\News;
use Ramsey\Uuid\Uuid;

class HtmlNewsReportGenerator implements NewsReportGeneratorInterface
{
    private const EXTENSION = 'html';

    /**
     * @param News[] $news
     */
    public function generate(array $news): NewsReportDto
    {
        $content = '<ul>';

        foreach ($news as $new) {
            $content .= sprintf('<li><a href="%s">%s</a></li>', $new->getUrl(), $new->getName());
        }

        $content .= '</ul>';

        return new NewsReportDto($this->render($content), Uuid::uuid4()->toString(), self::EXTENSION);
    }

    private function render(string $content): string
    {
        return sprintf(
            '<!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <title>News Report</title>
                    </head>
                    <body>
                        %s
                    </body>
                    </html>',
            $content
        );
    }
}
