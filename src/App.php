<?php
declare(strict_types=1);

namespace Skudashkin\Hw16;

use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\ORMSetup;

class App{

    public function runApp1() {
     
        phpinfo();

    }    

    public function runApp() {
    
        // Create a simple "default" Doctrine ORM configuration for Attributes
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: [__DIR__ . '/'],
            isDevMode: true,
        );

        // configuring the database connection
        $connectionParams = array(
            'dbname' => 'otus',
            'user' => 'otus',
            'password' => 'otus',
            'host' => 'localhost',
            'port' => 33060,
            'driver' => 'pdo_mysql',
        );
        $connection = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);

        // obtaining the entity manager
        $entityManager = new EntityManager($connection, $config);    


        $dql = "SELECT SUM(l.count) as count, p.name as name FROM Skudashkin\Hw16\OrderLine l INNER JOIN l.order o INNER JOIN l.product p"
        ."WHERE o.date = ?1 GROUP BY p OREDER BY p.name";       

        $now = new \DateTime("now"); $now->setTime(0,0,0);

        $myData = $entityManager->createQuery($dql)
                            ->setParameter(1, $now)
                            //->setMaxResults(10)
                            ->getResult();

            //echo "You have created " . count($myData) . " lines data:\n\n";
            //var_dump($myData);
            foreach ($myData as $data) {
                //var_dump($data);
                echo $data['name']. " - " . $data['count']. "\n";
            }
        }
}

  
