<?php

declare(strict_types=1);

require './vendor/autoload.php';

function get_all_lines($filename)
{
    $file_handle = fopen($filename, 'r');
    while (!feof($file_handle)) {
        yield fgets($file_handle);
    }
}


$client = Elastic\Elasticsearch\ClientBuilder::create()
    ->setHosts(['https://elasticsearch:9200'])
    ->setBasicAuthentication('elastic', 'a2+t7Skc0A*cv5Gsb4Sg')
    ->setSSLVerification(false)
//    ->setCABundle('/usr/lib/ssl/certs/http_ca.pem') cURL error 60: SSL certificate problem: self-signed certificate in certificate chain
    ->build();

//$params = [
//    'index' => 'my_index'
//];
//$client->indices()->delete($params);

$client->indices()->create([
    'index' => 'otus-shop',
    'body' => [
        'settings' => [
            'analysis' => [
                'filter' => [
                    'ru_stop' => [
                        'type' => 'stop',
                        'stopwords' => '_russian_'
                    ],
                    'ru_stemmer' => [
                        'type' => 'stemmer',
                        'language' => 'russian'
                    ]
                ],
                'analyzer' => [
                    'my_russian' => [
                        'tokenizer' => 'standard',
                        'filter' => [
                            'lowercase',
                            'ru_stop',
                            'ru_stemmer'
                        ]
                    ]
                ],
            ]
        ],
        'mappings' => [
            '_source' => [
                'enabled' => true
            ],
            'properties' => [
                'title' => [
                    'type' => 'text',
                    'analyzer' => 'my_russian'
                ],
                'sku' => [
                    'type' => 'text'
                ],
                'category' => [
                    'type' => 'keyword'
                ],
                'price' => [
                    'type' => 'integer'
                ],
                'stock' => [
                    'type' => 'nested',
                    'properties' => [
                        'shop' => [
                            'type' => 'keyword'
                        ],
                        'stock' => [
                            'type' => 'short'
                        ]
                    ]
                ],
            ]
        ]
    ]
]);

foreach (get_all_lines(__DIR__ . '/books.json') as $line) {
    $params[] = json_decode($line, true);
}
$client->bulk(['body' => $params]);
