<?php

namespace Dmigrishin\FirstHomework;

use Dmigrishin\FirstHomework\Database\Testredis;
use Dmigrishin\FirstHomework\Database\Database;
use Dmigrishin\FirstHomework\Database\Testmemcached;

class FirstHomework
{

    
    public static function connect(){

        $connect = new FirstHomework();
        $connect->testRedis();
        $connect->testMyDatabase();
        $connect->testMemcached();
    }

    private function testRedis(){

        $testredis = Testredis::testRedis();

    }

    private function testMyDatabase(){

        $testmysql = Database::testMysql();

    }
    
    private function testMemcached(){

        $testmemcached = Testmemcached::testMemcached();

    }
        

}