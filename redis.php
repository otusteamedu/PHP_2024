<?php

$redis = new Redis();

try{
    $redis->connect('127.0.0.1', 6380); 
    echo $redis->ping('Begin test').'<br/>';
}
catch(RedisException $ex){
    var_dump($ex);
    exit;
}
echo $redis->flushAll().'<br/>';

echo $redis->zAdd('conditions:param1', 1000, '1').'<br/>';
echo $redis->zAdd('event:event1', 1000, 'ok').'<br/>';

echo $redis->zAdd('conditions:param1', 2000, 2).'<br/>';
echo $redis->zAdd('conditions:param2', 2000, 2).'<br/>';
echo $redis->zAdd('event:event1', 2000, 'ok').'<br/>';

echo $redis->zAdd('conditions:param1', 3000, 1).'<br/>';
echo $redis->zAdd('conditions:param2', 3000, 2).'<br/>';
echo $redis->zAdd('event:event1', 3000, 'ok').'<br/>';

var_dump($redis->zRevRangeByScore('conditions:param1', 5000, 0, ['WITHSCORES'=>true])); // 
echo '<br/>';

//var_dump($redis->zRangeByScore('conditions:param1', 0, 5000, ['WITHSCORES'=>true])); // 
//echo '<br/>';

var_dump($redis->zUnion(['conditions:param1', 'conditions:param2'])); 
echo '<br/>';
