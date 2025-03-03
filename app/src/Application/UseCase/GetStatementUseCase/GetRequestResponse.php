<?php

namespace App\Application\UseCase\GetStatementUseCase;

use App\Domain\Entity\Request;
use OpenApi\Attributes as OA;

class GetRequestResponse
{
    public function __construct(
        public string $status
    ) {
    }
}
