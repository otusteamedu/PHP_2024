<?php

declare(strict_types=1);

namespace App\Application\UseCase;

final class GenerateReportTemplate
{
    public function __invoke(array $news): string
    {
        $content = '<meta charset="UTF-8"><ul>';

        foreach ($news as $item) {
            $content .= "<a href='{$item->getUrl()}'>{$item->getTitle()}</a><br>";
        }

        $content .= '</ul>';

        return $content;
    }
}
