<?php

namespace Naimushina\ElasticSearch\Storages;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Naimushina\ElasticSearch\Repositories\ElasticSearchRepository;
use Naimushina\ElasticSearch\Repositories\RepositoryInterface;

interface StorageInterface
{
    /**
     * @param string $fullPath
     * @return mixed
     */
    public function seedFromFile(string $fullPath): mixed;

    /**
     * @param $repository
     * @param array $params
     * @return array
     */
    public function search( RepositoryInterface $repository, array $params): array;

    /**
     * @return bool
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    public function clear(): bool;

}

