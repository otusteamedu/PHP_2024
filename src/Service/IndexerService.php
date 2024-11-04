<?php

namespace VSukhov\Hw12\Service;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class IndexerService
{
    private SearchService $esService;

    public function __construct(SearchService $esService)
    {
        $this->esService = $esService;
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function loadBooksFromFile($filePath): void
    {
        $data = file_get_contents($filePath);
        $lines = explode("\n", $data);

        foreach ($lines as $line) {
            $document = json_decode($line, true);
            if (isset($document['create'])) {
                continue;
            }
            $this->esService->indexDocument('otus-shop', $document);
        }
    }
}
