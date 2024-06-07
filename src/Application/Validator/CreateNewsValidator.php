<?php

declare(strict_types=1);

namespace App\Application\Validator;

use App\Application\UseCase\Request\CreateNewsRequest;
use InvalidArgumentException;

class CreateNewsValidator implements CreateNewsValidatorInterface
{
    public function validate(CreateNewsRequest $createNewsRequest): void
    {
        if (empty($createNewsRequest->url)) {
            throw new InvalidArgumentException('URL is required.');
        }

        if (!filter_var($createNewsRequest->url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Invalid URL format.');
        }
    }
}
