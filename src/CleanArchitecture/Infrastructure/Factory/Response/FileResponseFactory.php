<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Factory\Response;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Stream;

class FileResponseFactory
{
    public function createDownloadHtmlResponse(
        Response $response,
        string $fullFilename,
        ?string $filename = null,
        int $statusCode = 200
    ): Response {
        if ($filename === null) {
            $filename = basename($fullFilename);
        }

        $fileHandler = fopen($fullFilename, 'rb');
        $stream = new Stream($fileHandler);
        return $response
            ->withStatus($statusCode)
            ->withHeader('Content-type', 'application/text-html')
            ->withHeader('Content-Disposition', 'attachment;filename= '. $filename)
            ->withHeader('Content-Length', filesize($fullFilename))
            ->withHeader('Content-Transfer-Encoding', 'Binary')
            ->withBody($stream);
    }
}
