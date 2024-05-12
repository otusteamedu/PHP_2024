<?php
declare(strict_types=1);

namespace App\Storage\RedisStorage;


use Redis;

class RedisStorage
{
    private Redis $redis;
    const HASHKEY = 'hEvents';
    const ZSETKEY = 'zEvents';

    public function __construct(string $host)
    {
        $this->redis = new Redis();
        $this->redis->connect($host);
    }

    public function addItem(array $params): string
    {
        $this->redis->hSet(self::HASHKEY,$params['conditions'],$params['event']);
        $this->redis->zAdd(self::ZSETKEY, $params['priority'],$params['conditions']);
        return "Event successfully added.";
    }

    public function getEvent(array $arguments): string
    {
        $userProperty = $arguments[1];
        $conditions = [];
        $event_id = null;

        $it = NULL;
        $this->redis->setOption(Redis::OPT_SCAN, Redis::SCAN_RETRY);
        $score = 0;
        while($arr_matches = $this->redis->zScan('zEvents', $it, '*'.$userProperty.'*')) {
            foreach($arr_matches as $str_mem => $f_score) {
                $conditions[$f_score] = $str_mem;
                if ($f_score >= $score) $score = $f_score;
            }
            $event_id = $conditions[$score];
        }

        $event = $this->redis->hGet('hEvents',$event_id);
        return "Подходящий эвент: ".$event.PHP_EOL;
    }

    public function deleteItems(): string
    {
        $this->redis->del('hEvents');
        $this->redis->del('zEvents');
        return "Events successfully deleted.";
    }

}