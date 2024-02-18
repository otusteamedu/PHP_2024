<?php

declare(strict_types=1);

namespace App\Validator;

use App\Exception\DomainException;
use App\Request\CheckParenthesesRequest;

final class CheckParenthesesRequestValidator
{
    /**
     * @throws DomainException
     */
    public function validate(CheckParenthesesRequest $request): void
    {
        if (empty($request->string)) {
            throw new DomainException('Параметр string не может быть пустым');
        }

        if (mb_strlen($request->string) > 255) {
            throw new DomainException('Параметр string не может содержать больше 255 символов');
        }
    }
}