<?php

namespace Dmigrishin\FirstHomework\Database;

class Testmemcached 
{

    static function testMemcached()
    {
        $memcached = new \Memcached();

        $memcached->addServer('memcached', 11211);
        $memcached->set("ping", "Memcached is running");
        echo $memcached->get("ping") . "<br/>";
    }
    
}