<?php

declare(strict_types=1);

namespace App\Application\Validator;

use App\Application\UseCase\Request\CreateNewsRequest;

interface CreateNewsValidatorInterface
{
    public function validate(CreateNewsRequest $createNewsRequest): void;
}
