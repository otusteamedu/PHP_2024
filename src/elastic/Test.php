<?php

declare(strict_types=1);

namespace hw14\elastic;

use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Mock\Client as MockClient;
use Nyholm\Psr7\Response;

class Test implements ElasticInterface
{
    public function exec()
    {
        try {
            $mock = new MockClient();
            $client = ClientBuilder::create()
                ->setHttpClient($mock)
                ->build();

            $response = new Response(
                200,
                [Elasticsearch::HEADER_CHECK => Elasticsearch::PRODUCT_NAME],
                'Elastic is ready!'
            );

            $mock->addResponse($response);
            $info = $client->info();

            $result = $info->asString();
        } catch (\Throwable $e) {
            $result = $e->getMessage();
        }

        return $result;
    }
}
