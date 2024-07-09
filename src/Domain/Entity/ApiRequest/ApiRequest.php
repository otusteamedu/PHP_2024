<?php

declare(strict_types=1);

namespace App\Domain\Entity\ApiRequest;

use App\Domain\Enum\ApiRequestStatuses;
use App\Domain\ValueObject\ApiRequestBody;

class ApiRequest
{
    private int $id;

    public function __construct(private ApiRequestBody $body, private ApiRequestStatuses $status)
    {
    }

    public static function fromState(object $data): self
    {
        $apiRequest = new self(new ApiRequestBody($data->body), ApiRequestStatuses::from($data->status));
        $apiRequest->id = $data->id;

        return $apiRequest;
    }

    public function getStatus(): ApiRequestStatuses
    {
        return $this->status;
    }

    public function getBody(): ApiRequestBody
    {
        return $this->body;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setStatus(ApiRequestStatuses $status): self
    {
        $this->status = $status;

        return $this;
    }
}
