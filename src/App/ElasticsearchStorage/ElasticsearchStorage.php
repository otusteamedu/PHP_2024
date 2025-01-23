<?php

declare(strict_types=1);

namespace App\ElasticsearchStorage;

use App\Api\ElasticsearchClient;
use App\ElasticsearchStorage\Query\ChannelQuery;
use App\ElasticsearchStorage\Query\VideoQuery;
use App\Storage\Storage;

class ElasticsearchStorage implements Storage
{

    private ElasticsearchClient $client;
    private ChannelQuery $channelQuery;
    private VideoQuery $videoQuery;

    public function __construct()
    {
        $this->client = new ElasticsearchClient();

        $this->channelQuery = new ChannelQuery();
        $this->videoQuery = new VideoQuery();
    }


    public function migrate(): void
    {
        $this->client->createIndex($this->channelQuery->getMapping());
        $this->client->createIndex($this->videoQuery->getMapping());
    }

    public function addChannel(array $data): void
    {
//        $this->client->index($this->channelQuery->createQuery($data));

//        Заполняем бд тестовыми данными
        $db = include 'data.php';
        $items = $db['channels'];

        foreach ($items as $data) {
            $this->client->addDoc($this->channelQuery->createDocQuery($data));
        }
    }

    public function addVideo(array $data): void
    {
//        $this->client->index($this->videoQuery->createQuery($data));

//        Заполняем бд тестовыми данными
        $db = include 'data.php';
        $items = $db['videos'];

        foreach ($items as $data) {
            $this->client->addDoc($this->videoQuery->createDocQuery($data));
        }
    }
}