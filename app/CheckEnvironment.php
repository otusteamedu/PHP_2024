<?php
namespace App;

use Memcached;
use PDO;
use PDOException;


class CheckEnvironment
{

    public function testEnvironment()
    {
        $this->testDbConnection();
        echo "<\br>";
    }

    private function testDbConnection()
    {
    
        try {
            $mysql = new PDO(
                "mysql:host=db;dbname=database",
                'user',
                'secret',
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            echo "MySql connected";
           
        } catch (PDOException $ex) {
            var_dump($ex);
            echo 'MySql connect failed';
        }
    }
}
