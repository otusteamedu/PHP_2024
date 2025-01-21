<?php
declare(strict_types=1);

namespace Skudashkin\Hw14;

use Predis;

class App{

    public function runApp() {
        
        $client = new Predis\Client([
            'scheme' => 'tcp',
            'host'   => 'redis',
            'port'   => 6379,
        ]);

        $client->connect();
        $client->flushAll();
        
        echo $client->zAdd('conditions:param1', 1000, '1').'<br/>';
        echo $client->zAdd('event:event1', 1000, 'ok').'<br/>';

        echo $client->zAdd('conditions:param1', 2000, 2).'<br/>';
        echo $client->zAdd('conditions:param2', 2000, 2).'<br/>';
        echo $client->zAdd('event:event1', 2000, 'ok').'<br/>';

        echo $client->zAdd('conditions:param1', 3000, 1).'<br/>';
        echo $client->zAdd('conditions:param2', 3000, 2).'<br/>';
        echo $client->zAdd('event:event1', 3000, 'ok').'<br/>';

        var_dump($client->zRevRangeByScore('conditions:param1', 5000, 0, ['WITHSCORES'=>true])); // 
        echo '<br/>';

        //var_dump($client->zRangeByScore('conditions:param1', 0, 5000, ['WITHSCORES'=>true])); // 
        //echo '<br/>';

        var_dump($client->zUnion(['conditions:param1', 'conditions:param2'])); 
 
        $client->disconnect();
    }
}

