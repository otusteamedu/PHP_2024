<?php

declare(strict_types=1);

namespace AShutov\Hw14;

use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Exception;

class App
{
    public function __construct(
        private mixed $settings,
        private mixed $env,
        private string $dump
    ) {

    }

    /**
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     * @throws Exception
     */
    public function run(): string
    {
        $config = new Config($this->settings, $this->env);
        $client = new ElasticHandler($config);
        $client->createIndex($config->elasticIndex, false);
        $client->bulk($this->dump);
        $search = new BookSearch($client);

        foreach ($search->fields() as $field => $fieldName) {
            $search->$field = readline($fieldName);
        }

        return $search->search();
    }
}
