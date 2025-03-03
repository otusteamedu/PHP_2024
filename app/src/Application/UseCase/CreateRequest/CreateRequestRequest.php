<?php

namespace App\Application\UseCase\CreateRequest;

use OpenApi\Attributes as OA;

class CreateRequestRequest
{
    #[OA\Property(description: 'The name of the requester')]
    public string $requesterName;

    #[OA\Property(description: 'The email of the requester')]
    public string $requesterEmail;

    // Constructor
    public function __construct(
        string $requesterName,
        string $requesterEmail
    ) {
        $this->requesterName = $requesterName;
        $this->requesterEmail = $requesterEmail;
    }
}
