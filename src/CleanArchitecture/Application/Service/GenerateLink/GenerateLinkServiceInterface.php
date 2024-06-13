<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\Service\GenerateLink;

interface GenerateLinkServiceInterface
{
    public function generateLinkToNewsReportToFile(GenerateLinkParams $params): GenerateLinkResult;
}
