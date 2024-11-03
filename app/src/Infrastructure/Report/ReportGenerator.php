<?php

declare(strict_types=1);

namespace App\Infrastructure\Report;

use App\Domain\Report\ReportGeneratorInterface;
use App\Domain\Entity\Report;
use App\Infrastructure\Helpers\LoadConfig;

class ReportGenerator implements ReportGeneratorInterface
{
    private string $header;
    private string $footer;

    public function __construct()
    {
        $config = LoadConfig::loadTemplate();
        $this->header = $config['header'];
        $this->footer = $config['footer'];
    }

    public function generateHTML(iterable $newsList): ?Report
    {
        $result = $this->header;

        if (!empty($newsList)) {
            $result .= "<ul>";
        }

        foreach ($newsList as $oneNews) {
            $link = $title = "";
            $link = $oneNews->getUrl()->getValue();
            $title = $oneNews->getTitle()->getValue();
            $result .= '<li><a target="_blank" href="' . htmlspecialchars($link) . '">' . htmlspecialchars($title) . '</a></li>';
        }

        if (!empty($newsList)) {
            $result .= "</ul>";
        }

        $result .= $this->footer;

        return new Report($result);
    }
}
