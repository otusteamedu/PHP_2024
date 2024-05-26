<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\Service\ParseUrl;

interface ParseUrlServiceInterface
{
    /**
     * @param string $url
     * @return string
     * @throws TitleNotFoundException
     * @throws UrlNotFoundException
     */
    public function parse(string $url): string;
}