<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway;

use App\Application\Gateway\FileStorageGatewayInterface;
use App\Application\Gateway\FileStorageGatewayRequest;
use App\Application\Gateway\FileStorageGatewayResponse;

class FileStorageGateway implements FileStorageGatewayInterface
{
    public function saveFile(FileStorageGatewayRequest $request): FileStorageGatewayResponse
    {
        $filePath = rtrim($request->directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $request->fileName;

        if (!is_dir(dirname($filePath))) {
            if (!mkdir($concurrentDirectory = dirname($filePath), 0777, true) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }
        }

        file_put_contents($filePath, $request->content);

        return new FileStorageGatewayResponse($filePath);
    }
}
