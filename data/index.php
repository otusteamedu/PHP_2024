<?php
declare(strict_types=1);

$arr = [];

$redis = new Redis();
$redis->connect(getenv('REDIS_HOST'));
//if ($redis->ping()) {
//    $arr['redis'] = "Redis is work!";
//}

//{
//    priority: 1000,
//    conditions: {
//        param1 = 1
//    },
//    event: {
//        ::event::
//    },
//}

try {
    $redis->zAdd('Event Set',1000, "{conditions: {param1 = 1}, event: {::event::}}");
} catch (\Exception $e) {
    echo $e->getMessage();
}

//$it = NULL;
//$redis->setOption(Redis::OPT_SCAN, Redis::SCAN_RETRY);
//while($arr_matches = $redis->zScan('zset', $it, '*pattern*')) {
//    foreach($arr_matches as $str_mem => $f_score) {
//        echo "Key: $str_mem, Score: $f_score\n";
//    }
//}

var_dump($redis->zRange('Event Set',0,-1,true));

//var_dump($redis->zGet());