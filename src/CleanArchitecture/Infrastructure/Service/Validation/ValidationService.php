<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Service\Validation;

use AlexanderGladkov\CleanArchitecture\Application\Service\Validation\RequestValidationServiceInterface;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\Request\News\AddNewsRequest;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\Request\News\GenerateNewsReportRequest;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\Request\Report\GetNewsReportRequest;
use AlexanderGladkov\CleanArchitecture\Domain\Entity\News;
use AlexanderGladkov\CleanArchitecture\Domain\Service\Validation\ValidationServiceInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationService implements RequestValidationServiceInterface, ValidationServiceInterface
{
    private ViolationHelper $violationHelper;

    public function __construct(private ValidatorInterface $validator)
    {
        $this->violationHelper = new ViolationHelper();
    }

    public function validateAddNewsRequestRequest(AddNewsRequest $request): array
    {
        return $this->validateObject($request);
    }

    public function validateGetNewsReportRequest(GetNewsReportRequest $request): array
    {
        return $this->validateObject($request);
    }

    public function validateGenerateNewsReportRequest(GenerateNewsReportRequest $request): array
    {
        return $this->validateObject($request);
    }

    public function validateNews(News $news): array
    {
        return $this->validateObject($news);
    }

    private function validateObject(mixed $object): array
    {
        $errors = $this->validator->validate($object);
        if (count($errors) > 0) {
            return $this->violationHelper->convertListToArray($errors);
        } else {
            return [];
        }
    }
}

