<?php

declare(strict_types=1);

namespace AlexanderGladkov\Bookshop\Application\Action;

use AlexanderGladkov\Bookshop\Application\Config;
use AlexanderGladkov\Bookshop\Elasticsearch\ElasticsearchClient;
use AlexanderGladkov\Bookshop\Elasticsearch\ElasticsearchClientFactory;
use Elastic\Elasticsearch\Exception\AuthenticationException;

abstract class BaseAction
{
    protected ElasticsearchClient $elasticsearchClient;

    /**
     * @throws AuthenticationException
     */
    public function __construct(protected Config $config)
    {
        $this->elasticsearchClient = (new ElasticsearchClientFactory())
            ->createWithNoAuthentication($config->getHost());
    }

    abstract public function run(array $args = []): Response;
}
