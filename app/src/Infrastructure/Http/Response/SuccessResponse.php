<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response;

use App\Infrastructure\Http\Traits\ResponseTrait;

class SuccessResponse
{
    use ResponseTrait;

    public function __construct(public readonly mixed $data)
    {
        $this->setSuccess(true);
    }
}
