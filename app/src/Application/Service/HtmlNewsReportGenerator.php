<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Dto\NewsReportDto;
use App\Domain\Entity\News;
use App\Domain\Service\NewsReportGeneratorInterface;

class HtmlNewsReportGenerator implements NewsReportGeneratorInterface
{
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

        return new NewsReportDto($this->render($content), 'html');
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
