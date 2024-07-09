<?php

declare(strict_types=1);

namespace App\Domain\Entity\ApiRequest;

interface ApiRequestRepositoryInterface
{
    public function find(int $id): ApiRequest;

    public function store(ApiRequest $apiRequest): void;

    public function update(ApiRequest $apiRequest): void;
}
