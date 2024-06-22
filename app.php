<?php

declare(strict_types=1);

use App\Kitchen\Kitchen;

spl_autoload_register(
    function (string $class) {
        $class = str_replace('App\\', 'src\\', $class);
        $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
        if (file_exists($file)) {
            require $file;
            return true;
        }
        return false;
    },
);

$kitchen = new Kitchen();

echo "Готовим бургер\n";
sleep(1);
$burger = $kitchen->makeBurger();

echo $burger->getComposition();

exit();

//echo "Added additional ingredients\n";
//$burgerWithAdditionalIngredients = new ProductWithAdditionalIngredients($burger);
//$burgerWithAdditionalIngredients->addIngredient(
//    new Ingredient('Зеленый лук', 100, 10)
//);
//
//echo "Price standard: {$burger->getPrice()}\n";
//echo "Price additional: {$burgerWithAdditionalIngredients->getPrice()}\n";
//
//echo "Приготовлен продукт: {$burgerWithAdditionalIngredients->getName()}\n";
//echo "Состав:\n";
//foreach ($burger)
