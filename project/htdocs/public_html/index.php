<?php
require_once "../vendor/autoload.php";

use App\Events\QualityControlEvent;
use App\Kitchen;
use App\Strategy\ClassicBurgerStrategy;

echo "Creating kitchen...<br>";
$kitchen = new Kitchen();
$kitchen->setEvents(new QualityControlEvent());

echo "Preparing classic burger...<br>";
$builder = $kitchen->createBurger(new ClassicBurgerStrategy());
echo "Add ingridient...<br>";
$builder->addIngredient('cheese')
    ->addIngredient('bacon');
echo "Remove ingridient...<br>";
$builder->removeIngredient('lettuce');
$customBurger = $builder->build();
echo $customBurger->getDescription() . "<br>";