<?php

declare(strict_types=1);

namespace hw14;

use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Mock\Client;
use Nyholm\Psr7\Response;

class ElasticService
{
    public function testConnection()
    {
        $mock = new Client();

        try {
            $client = ClientBuilder::create()
                ->setHttpClient($mock)
                ->build();

            $response = new Response(
                200,
                [Elasticsearch::HEADER_CHECK => Elasticsearch::PRODUCT_NAME],
                'This is the body!'
            );
            $mock->addResponse($response);

            $result = $client->info();

            echo $result->asString();
        } catch (\Throwable $e) {
            $result = $e->getMessage();
        }

        return $result;
    }

}
