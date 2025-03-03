<?php

namespace App\Application\UseCase\GetStatementUseCase;

use OpenApi\Attributes as OA;

class GetRequestRequest
{
    #[OA\Property(description: 'The unique ID of the request(provided when request made)')]
    public int $requestId;

    public function __construct(int $requestId)
    {
        $this->requestId = $requestId;
    }
}
