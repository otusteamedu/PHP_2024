<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Elastic\Elasticsearch\ClientBuilder;

$client = ClientBuilder::create()
    ->setHosts(['https://elastic:9200'])
    ->setBasicAuthentication('elastic', '_osHo1z=ne7sDq44S+4z')
    ->setSSLVerification(false)
    ->build();

try {
    $response = $client->cluster()->health();
    echo "Elasticsearch cluster is up and running!<br>";
    echo "Cluster Health: " . $response['status'] . "<br>";
    echo "Node Count: " . $response['number_of_nodes'] . "<br>";
    echo "Active Primary Shards: " . $response['active_primary_shards'] . "<br>";
    echo "Active Shards: " . $response['active_shards'] . "<br>";
} catch (Exception $e) {
    echo "Elasticsearch is not reachable: " . $e->getMessage();
}
