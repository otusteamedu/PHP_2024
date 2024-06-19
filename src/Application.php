<?php

declare(strict_types=1);

namespace Pozys\BankStatement;

use Nyholm\Psr7\Factory\Psr17Factory;
use Pozys\BankStatement\Application\DTO\BankStatementRequest;
use Pozys\BankStatement\Application\UseCase\GetBankStatementAsyncUseCase;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface, StreamInterface};

class Application
{
    public function __construct(
        private Psr17Factory $psr17Factory,
        private GetBankStatementAsyncUseCase $bankStatementAsyncUseCase
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = match (strtoupper($request->getMethod())) {
            'GET' => $this->sendForm(),
            'POST' => $this->handleRequest($request->getParsedBody()),
            default => throw new \RuntimeException('Method not allowed'),
        };

        return $this->psr17Factory->createResponse(200)->withBody($response);
    }

    private function sendForm(): StreamInterface
    {
        return $this->psr17Factory->createStreamFromFile(dirname(__DIR__) . '/public/resources/views/report.html');
    }

    private function handleRequest(array $params): StreamInterface
    {
        $bankStatementRequest = BankStatementRequest::fromRequest($params);

        try {
            ($this->bankStatementAsyncUseCase)($bankStatementRequest);
        } catch (\Throwable $e) {
            return $this->psr17Factory->createStream('Error: ' . $e->getMessage());
        }

        return $this->psr17Factory->createStream('Wait for email...');
    }
}
