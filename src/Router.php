<?php

declare(strict_types=1);

namespace Pozys\OtusShop;

use Pozys\OtusShop\Elastic\{DataLoader, DocumentSearch};
use Pozys\OtusShop\Services\{ElasticService, IOProcessor};

class Router
{
    public function __construct(
        private IOProcessor $IOProcessor,
        private ElasticService $elasticService,
        private DocumentSearch $documentSearch,
        private DataLoader $loader,
    ) {
    }

    public function handle(array $data): void
    {
        match ($data['command']) {
            'search' => $this->runSearch($data),
            'bulk' => $this->runBulk($data),
        };
    }

    private function runSearch(array $data): void
    {
        $response = $this->elasticService->search($data);
        $this->IOProcessor->printArray($response);
    }

    private function runBulk(array $data): void
    {
        $message = $this->elasticService->bulk($data['path']) ? 'Success!' : 'Failed!';
        $this->IOProcessor->print($message);
    }
}
