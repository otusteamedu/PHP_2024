<?php

namespace App\Services;

use App\Base\Config;
use App\Contracts\ConnectorInterface;
use App\Enums\LogLevelEnum;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Helper\Iterators\SearchHitIterator;
use Elastic\Elasticsearch\Helper\Iterators\SearchResponseIterator;
use Exception;

class ElasticConnector implements ConnectorInterface
{
    public Client $client;

    /**
     * @throws AuthenticationException
     */
    public function __construct(private readonly Config $config)
    {
        $this->client = ClientBuilder::create()
            ->setSSLVerification(false)
            ->setHosts([$config->elasticHost]) // https!
            ->setBasicAuthentication('elastic', $this->config->elasticPassword) // Пароль
            ->build();
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function createIndex(string $index): bool
    {
        if ($this->client->indices()->exists(['index' => $index])->asBool()) {
            $this->dropIndex($index);
        }

        $params = [
            'index' => $index,
            'body' => [
                ...$this->config->indexSettings
            ]
        ];

        return $this->client->indices()->create($params)->asBool();
    }

    public function bulk(string $dataPath): void
    {
        exec(
            "curl --location --insecure -u elastic:{$this->config->elasticPassword} --request POST '{$this->config->elasticHost}/_bulk' --header 'Content-Type: application/json' --data-binary '@$dataPath'"
        );
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function dropIndex(string $index): bool
    {
        return $this->client->indices()->delete(['index' => $index])->asBool();
    }

    /**
     * @throws Exception
     */
    public function search(array $query): SearchHitIterator
    {

        Logger::getInstance()->writeLog(
            LogLevelEnum::INFO,
            ['type' => 'search', $query],
            $this->config->logPath
        );


        $pages = new SearchResponseIterator($this->client, $query);

        $hits = new SearchHitIterator($pages);

        Logger::getInstance()->writeLog(
            LogLevelEnum::SUCCESS,
            ['type' => 'search-result', 'qty' => $hits->count()],
            $this->config->logPath
        );

        return $hits;
    }
}
