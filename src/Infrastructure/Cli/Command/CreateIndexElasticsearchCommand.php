<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\Command;

use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\ClientInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:elasticsearch:create:index', description: 'Create Elasticsearch index')]
class CreateIndexElasticsearchCommand extends Command
{
    private ClientInterface $client;
    public function __construct()
    {
        parent::__construct();
        $this->client = ClientBuilder::create()
            ->setSSLVerification(false)
            ->setHosts([$_ENV['ES_HOST'] . ':' . $_ENV['ES_PORT']])
            ->build();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->client->indices()->create(
            [
                'index' => 'events',
                'body' => [
                    'mappings' => [
                        'properties' => [
                            'event' => ['type' => 'keyword'],
                            'priority' => ['type' => 'integer'],
                            'condition' => [
                                'type' => 'nested',
                                'properties' => [
                                    'param' => ['type' => 'keyword'],
                                    'value' => ['type' => 'keyword']
                                ]
                            ],
                        ]
                    ]
                ]
            ]
        );
        return Command::SUCCESS;
    }
}
