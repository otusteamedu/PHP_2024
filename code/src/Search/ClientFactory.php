<?php

declare(strict_types=1);

namespace Viking311\Books\Search;

use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Viking311\Books\Config\Config;

class ClientFactory
{
    /**
     * @return Client
     * @throws AuthenticationException
     */
    public static function createInstance(): Client
    {
        $config = new Config();

        $builder = ClientBuilder::create()
        ->setHosts([$config->host]);

        if (!empty($config->user) && !empty($config->password)) {
            $builder->setBasicAuthentication(
                $config->user,
                $config->password
            );
        }

        if (!empty($config->caCert)) {
            $builder->setCABundle($config->caCert);
        }

        return new Client(
            $builder->build(),
            new QueryBuilder($config->index)
        );
    }
}
