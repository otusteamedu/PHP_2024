<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\Service\Validation;

use AlexanderGladkov\CleanArchitecture\Application\UseCase\Request\News\AddNewsRequest;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\Request\Report\GetNewsReportRequest;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\Request\News\GenerateNewsReportRequest;

interface RequestValidationServiceInterface
{
    public function validateAddNewsRequestRequest(AddNewsRequest $request): array;
    public function validateGetNewsReportRequest(GetNewsReportRequest $request): array;
    public function validateGenerateNewsReportRequest(GenerateNewsReportRequest $request): array;
}
