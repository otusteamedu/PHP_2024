<?php

declare(strict_types=1);

namespace App\Infrastructure\Helpers;

class LoadConfig
{
    public static function load()
    {
        $newsPath = getenv('PATH_FILES_NEWS');
        $reportsPath = getenv('PATH_FILES_REPORT');
        $reportsPathSite = getenv('PATH_FILES_REPORT_SITE');

        if (!$newsPath) {
            throw new \DomainException("No isset PATH_FILES_NEWS in .env");
        }

        if (!$reportsPath) {
            throw new \DomainException("No isset PATH_FILES_REPORT in .env");
        }

        if (!$reportsPathSite) {
            throw new \DomainException("No isset PATH_FILES_REPORT_SITE in .env");
        }

        return [
            'newsPath' => $newsPath,
            'reportsPath' => $reportsPath,
            'reportsPathSite' => $reportsPathSite
        ];
    }

    public static function loadTemplate()
    {
        $header = getenv('REPORT_HEADER');
        $footer = getenv('REPORT_FOOTER');

        return [
            'header' => $header,
            'footer' => $footer
        ];
    }
}
