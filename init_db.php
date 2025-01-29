<?php
namespace Skudashkin\Hw16;
require_once "bootstrap.php";
use DateTime;

//erase OrderLine
$repo = $entityManager->getRepository(OrderLine::class);
$ols = $repo->findAll();
foreach($ols as $ol){
    $entityManager->remove($ol);    
}
$entityManager->flush();

//erase Products
$repo = $entityManager->getRepository(Product::class);
$products = $repo->findAll();
foreach($products as $product){
    $entityManager->remove($product);    
}
$entityManager->flush();

$repo = $entityManager->getRepository(Order::class);
$orders = $repo->findAll();
foreach($orders as $order){
    $entityManager->remove($order);    
}
$entityManager->flush();

//fill products
$names = ["pencil", "pen", "rubber", "pencil-box"];
$products =[];
foreach($names as $name){
    $product = new Product();
    $product->setName($name);
    $entityManager->persist($product);
    $products[] = $product;    
}
$countProducts = count($products);
$entityManager->flush();

//var_dump($products);

//fill order
$numbers = ["001", "002", "003"];
$now = new \DateTime("now");
foreach($numbers as $num){
    $order = new Order();
    $order->setNumber($num);
    $order->setDate($now);
    $entityManager->persist($order);
    //echo 'write order<br>';

    $countLines = rand(1,101);
    for($i=0; $i<$countLines; $i++) {
        $k = rand(0,$countProducts-1);
        //echo '<br>'.$k;
        $orderline = new OrderLine($order, $products[$k], strval(rand(1,101))); 
        $entityManager->persist($orderline); 
        //echo 'write +orderline<br>';  
    }
}
$entityManager->flush();

