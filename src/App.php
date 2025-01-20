<?php
declare(strict_types=1);

namespace Skudashkin\Hw14;

use Predis;

class App{

    public function runApp(): string{
        
        $client = new Predis\Client([
            'scheme' => 'tcp',
            'host'   => '127.0.0.1',
            'port'   => 6379,
            'password' => 'eYVX7EwVmmxKPCDmwMtyKVge8oLd2t81'
        ]);

        //$client = new Predis\Client();
        $client->connect();
        //$client->set('foo', 'bar');
        //$res = $client->get('foo');

        // $res = $client->transaction(function ($t) {
        //     $t->get('skey');
        //     $t->hset('hkey', 'k', 'v');
        //   });
        
        //$client->set('library', 'predis');
        //$res = $client->get('library');

        // $mkv = [
        //     'uid:0001' => '1st user',
        //     'uid:0002' => '2nd user',
        //     'uid:0003' => '3rd user',
        // ];
        
        //$client->mset($mkv);
        //$response = $client->mget(array_keys($mkv));

        //var_export($response);
        //return PHP_EOL;

        //$redis->flushAll();
        //$redis->zAdd('conditions:param1', 1000, '1');

        return 'connected';
    }
}

