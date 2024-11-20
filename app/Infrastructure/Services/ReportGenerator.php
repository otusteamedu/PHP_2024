<?php

namespace App\Infrastructure\Services;

use App\Domain\Services\ReportGeneratorInterface;

class ReportGenerator implements ReportGeneratorInterface
{
    public function generateHtml(iterable $newsEntities): string
    {
        $html = '<ul>';

        foreach ($newsEntities as $news) {
            $html .= sprintf(
                '<li><a href="%s">%s</a></li>',
                htmlspecialchars($news->url, ENT_QUOTES, 'UTF-8'),
                htmlspecialchars($news->title, ENT_QUOTES, 'UTF-8')
            );
        }

        $html .= '</ul>';

        return $html;
    }
}
