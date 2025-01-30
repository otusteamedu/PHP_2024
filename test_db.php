<?php
namespace Skudashkin\Hw16;
require_once "bootstrap.php";
use DateTime;

$dql = "SELECT l as count FROM Skudashkin\Hw16\OrderLine as l";

//$dql = "SELECT SUM(l.count) as count, p.name as name FROM Skudashkin\Hw16\OrderLine"
//." INNER JOIN l.order o INNER JOIN l.product p"
//." WHERE o.date = ?1 GROUP BY p OREDER BY p.name";       
//." GROUP BY p ";    

$now = new \DateTime("now"); $now->setTime(0,0,0);

$myData = $entityManager->createQuery($dql)
                    //->setParameter(1, $now)
                    ->setMaxResults(10)
                    ->getResult();

    //echo "You have created " . count($myData) . " lines data:\n\n";
    var_dump($myData);
    foreach ($myData as $data) {
        //var_dump($data);
        //echo $data['name']. " - " . $data['count']. "\n";
    }
