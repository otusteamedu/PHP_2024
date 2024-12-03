<?php

declare(strict_types=1);

namespace App\Application\Gateway;

class FileStorageGatewayRequest
{
    public function __construct(
        public readonly string $directory,
        public readonly string $fileName,
        public readonly string $content,
    ) {
    }
}
