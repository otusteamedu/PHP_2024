<?php

declare(strict_types=1);

namespace hw14\elastic;

use Elastic\Elasticsearch\ClientBuilder;

class ExistsIndex
{
    public function exec()
    {
        $client = ClientBuilder::create()
            ->setSSLVerification(false)
            ->setHosts([getenv('ELASTIC_HOST')])
            ->setBasicAuthentication(
                getenv('ELASTIC_USERNAME'),
                getenv('ELASTIC_PASSWORD')
            )
            ->build();

        $params = [
            'index' => getenv('ELASTIC_INDEX')
        ];

        return $client->exists($params);
    }
}
