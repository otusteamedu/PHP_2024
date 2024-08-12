<?php

declare(strict_types=1);

namespace AlexanderPogorelov\ElasticSearch\Response;

readonly class SearchResponse implements ResponseInterface
{
    public function __construct(private array $content)
    {
    }

    public function showResponse(): void
    {
        echo 'Search result (limited):' , PHP_EOL;

        $total = $this->content['hits']['total']['value'] ?? 0;

        if (0 < $total) {
            $records = $this->content['hits']['hits'];

            foreach ($records as $record) {
                echo $this->createRow($record) , PHP_EOL;
            }
        }

        echo sprintf('Total records found %s.', $total) , PHP_EOL;
    }

    private function createRow(mixed $record): string
    {
        return sprintf(
            'Score: %s, category %s, book: %s, price: %s | %s: %s | %s: %s',
            $record['_score'],
            $record['_source']['category'],
            $record['_source']['title'],
            $record['_source']['price'],
            $record['_source']['stock'][0]['shop'],
            $record['_source']['stock'][0]['stock'],
            $record['_source']['stock'][1]['shop'],
            $record['_source']['stock'][1]['stock'],
        );
    }
}
