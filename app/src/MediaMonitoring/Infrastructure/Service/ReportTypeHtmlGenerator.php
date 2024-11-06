<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Infrastructure\Service;

use App\MediaMonitoring\Domain\Entity\Post;
use App\MediaMonitoring\Domain\Enum\ReportType;
use App\MediaMonitoring\Domain\Service\ReportGeneratorInterface;

final readonly class ReportTypeHtmlGenerator implements ReportGeneratorInterface
{
    public function getType(): ReportType
    {
        return ReportType::HTML;
    }

    public function generate(Post ...$posts): string
    {
        $html = '';

        foreach ($posts as $post) {
            $html .= sprintf(
                '<li><a href="%s">%s</a></li>',
                $post->url,
                $post->title
            );
        }

        return '<ul>' . $html . '</ul>';
    }
}
