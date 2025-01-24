<?php

namespace App;

use App\ElasticsearchStorage\ElasticsearchStatistic;
use App\ElasticsearchStorage\ElasticsearchStorage;
use App\Storage\Statistic;
use App\Storage\Storage;

class App
{
    private Storage $storage;
    private Statistic $statistic;

    public function __construct()
    {
        $this->storage = new ElasticsearchStorage();
        $this->statistic = new ElasticsearchStatistic();
    }

    public function run()
    {
//        $this->seed();

        $responseLikes = $this->statistic->getLikesAndDislikesByChannel('channel-1');
//        Array ( [likes] => 303 [dislikes] => 75 )

        $responseBestChannelsRatio = $this->statistic->getBestChannelRatio();
//        Array ( [0] => Array ( [channel_id] => channel-2 [ratio] => 17.5 [sum_likes] => 105 [sum_dislikes] => 6 ) [1] => Array ( [channel_id] => channel-1 [ratio] => 4.04 [sum_likes] => 303 [sum_dislikes] => 75 ) )
    }

    private function seed()
    {
        $this->storage->migrate();

        $this->storage->addChannel([]);
        $this->storage->addVideo([]);
    }
}