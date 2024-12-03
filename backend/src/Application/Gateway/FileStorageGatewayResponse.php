<?php

declare(strict_types=1);

namespace App\Application\Gateway;

class FileStorageGatewayResponse
{
    public function __construct(
        public readonly string $filePath,
    ) {
    }
}
