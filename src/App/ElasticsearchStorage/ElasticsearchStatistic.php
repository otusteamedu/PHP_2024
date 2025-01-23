<?php

declare(strict_types=1);

namespace App\ElasticsearchStorage;

use App\Api\ElasticsearchClient;
use App\ElasticsearchStorage\Query\StatisticQuery;
use App\Storage\Statistic;

class ElasticsearchStatistic implements Statistic
{
    private ElasticsearchClient $client;
    private StatisticQuery $statisticQuery;

    public function __construct()
    {
        $this->client = new ElasticsearchClient();

        $this->statisticQuery = new StatisticQuery();
    }

    public function getLikesAndDislikesByChannel(string $channelId): array
    {
        $response = $this->client->search($this->statisticQuery->getLikesAndDislikesByChannel($channelId));

        return $this->statisticQuery->prepareLikesAndDislikesByChannel($response);
    }

    public function getBestChannelRatio(int $count = 3): array
    {
        $response = $this->client->search($this->statisticQuery->getBestChannelsByRatio($count));

        return $this->statisticQuery->prepareBestChannelsByRatio($response);
    }
}