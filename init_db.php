<?php
namespace Skudashkin\Hw16;
require_once "bootstrap.php";
use DateTime;

// $productRepository = $entityManager->getRepository('Product');
// $products = $productRepository->findAll();
// if(count($products) === 0){
//     //products
//     $names = ["pencil", "pen", "rubber", "pencil-box"];
//     $products =[];
//     foreach($names as $name){
//         $product = new Product();
//         $product->setName($name);
//         $entityManager->persist($product);
//         $products[] = $product;    
//     }
// }
//$entityManager->flush();

$products =[];
//order
$numbers = ["001", "002", "003"];
foreach($numbers as $num){
    $order = new Order();
    $order->setNumber($num);
    //$order->setDate(new DateTime());
    $entityManager->persist($order);
    
    foreach($product as $products){
        $orderline = new OrderLine($order, $product, "13"); 
        $entityManager->persist($order);   
    }
}
$entityManager->flush();

