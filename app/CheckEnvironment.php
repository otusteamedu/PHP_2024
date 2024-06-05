<?php
namespace App;

use Memcached;
use PDO;
use PDOException;
use Predis\Client;


class CheckEnvironment
{

    public function testEnvironment()
    {
        $this->testDbConnection();
        $this->testRedisConnection();
        $this->testMemcached();
    }

    private function testDbConnection()
    {
    
        try {
            
            $dns =  sprintf(
                '%s:host=%s;dbname=%s;charset=%s;port=%s',
                'mysql',
                'db',
                getenv('MYSQL_DATABASE'),
                'UTF8',
                '3306'
            );
            $opt = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $mysql = new PDO(
                $dns,
                getenv('MYSQL_USER'),
                getenv('MYSQL_PASSWORD'),
                $opt
            );
            echo "MySql connected" . "<br>";
           
        } catch (PDOException $ex) {
            echo 'MySql connect failed with message: ' ;
            echo $ex->getMessage() . "<br>";
        }
    }

    private function testRedisConnection()
    {
        try {
            $redis = new Client([
                'scheme' => 'tcp',
                'host' => 'cache',
                'port' => getenv('REDIS_PORT'),
                'password' => ''
            ]);
            echo "Redis successfully connected ping:" . $redis->ping() . "<br>";
            $redis->disconnect();
        } catch (\Throwable $e) {
            echo "Failed to connect to Redis with message " . $e->getMessage() . "<br>";
        }
       
    }

    private function testMemcached()
    {
        try {
            $memcahed = new Memcached();
            $memcahed->addServer('memcached', getenv('MEMCACHED_PORT'));
            echo "successfully connected to MemCached:";
        } catch (Throwable $e) {
            echo "Failed to connect to MemCached" . $e->getMessage() . "<br>";
        }
        
    }
}
