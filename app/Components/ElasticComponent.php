<?php

namespace App\Components;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;

readonly class ElasticComponent
{
    public Client $client;

    /**
     * @throws AuthenticationException
     */
    public function __construct(
        protected string $username = 'elastic',
        protected string $password = 'password',
        protected array $hosts = [
            'http://localhost:9200'
        ],
        protected bool $ssl = false
    ) {
        $this->client = ClientBuilder::create()
            ->setHosts($this->hosts)
            ->setBasicAuthentication($this->username, $this->password)
            ->setSSLVerification($this->ssl)
            ->build();
    }
}
