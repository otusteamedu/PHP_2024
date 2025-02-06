<?php
declare(strict_types=1);

namespace Skudashkin\Hw16;

use PDO;

class App
{
    public function runApp() {

        //phpinfo();

        // $host = "db";
        // $base = "otus";
        // $dsn = "mysql:dbname=".$base.";host=".$host;
        // $user = 'otus';
        // $password = 'otus';

        // $PDO = new PDO($dsn, $user, $password);
        $PDO = new PDO('mysql:dbname=otus;host=db;port=3306','otus', 'otus');

        $user = new \RowGateway\User($PDO);
        $user->setFirstName('test');
        $user->update();


        $activeRecordUser = new \ActiveRecord\User($PDO);
        $activeRecordUser->setEmail('test@test.com');

        $user = (new \DataMapper\UserMapper($PDO))->findById(1);
        $user->getFirstName();
        
    }   

}