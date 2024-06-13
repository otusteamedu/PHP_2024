<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\Service\ParseUrl;

interface ParseUrlServiceInterface
{
    /**
     * @throws TitleNotFoundException
     * @throws UrlNotFoundException
     */
    public function parse(ParseUrlParams $params): ParseUrlResult;
}
