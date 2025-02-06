<?php
declare(strict_types=1);

namespace Skudashkin\Hw16;

use PDO;
use PDOException;

class App
{
    public function runApp() {

        //phpinfo();
        $PDO = new PDO('mysql:dbname=otus;host=db;port=3306','otus', 'otus');
        try {
            $PDO->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
            $sql ="CREATE TABLE IF NOT EXISTS users(
            id INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(50) NOT NULL, 
            last_name VARCHAR(50),
            email VARCHAR( 50 )
            );" ;
            $PDO->exec($sql);
            print("Created users Table.\n");
       
       } catch(PDOException $e) {
           echo $e->getMessage();//Remove or change message in production code
       }

        $userTableGateway = new \Skudashkin\Hw16\TableGateway\User($PDO);
        $userTableGateway->insert('RowGateway','','');
        
        $userRowGateway = new \Skudashkin\Hw16\RowGateway\User($PDO);
        $userRowGateway->setFirstName('RowGateway');
        $userRowGateway->update();

        $activeRecordUser = new \Skudashkin\Hw16\ActiveRecord\User($PDO);
        $activeRecordUser->setFirstName('activeRecordUser');
        $activeRecordUser->setEmail('test@test.com');

        $user = (new \Skudashkin\Hw16\DataMapper\UserMapper($PDO))->findById(1);
        echo $user->getFirstName();
        
    }   

}