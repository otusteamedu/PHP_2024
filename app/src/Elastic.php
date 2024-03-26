<?php

namespace Kagirova\Hw14;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Http\Client\Exception;

class Elastic
{
    private Client $client;
    private const INDEX_NAME = 'otus-shop';

    public function __construct(private string $host, private string $user, private string $password)
    {
        $this->connect();
        $this->createIndex('../files/books.json');
    }

    private function connect()
    {
        $this->client = ClientBuilder::create()
            ->setHosts([$this->host])
            ->setBasicAuthentication($this->user, $this->password)
            ->build();

    }

    private function createIndex($fileName){
        $body = file_get_contents($fileName);
        $params = [
            'index'=>'index_name',
            'id'=>'1'
        ];
        echo $this->client->get($params);
        /*try {
            $this->client->index([
                'index' => self::INDEX_NAME,
                'body' => $body
            ]);
        } catch (Exception $e){
            echo $e;
        }*/
    }
}