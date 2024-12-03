<?php

declare(strict_types=1);

namespace App\Application\Gateway;

interface FileStorageGatewayInterface
{
    public function saveFile(FileStorageGatewayRequest $request): FileStorageGatewayResponse;
}
