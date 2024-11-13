<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Infrastructure\CreateOrder;

class App
{
    private $arAvailablesProduct = ['burger', 'sandwich', 'hotdog'];
    private $arAvailableIngredients = ['basic', 'cheese', 'cucumber', 'ham', 'meat', 'onion', 'pepper', 'salad', 'sauce', 'sausage'];

    public function run()
    {
        CreateOrder::create("burger", ['cheese', 'ham'], "tray");

        die();
        while (1) {
            $product = trim(readline('Какой продукт вы ходите заказать [возможные варианты: : ' . implode(", ", $this->arAvailablesProduct) . '], либо введите exit: '));
            if (strlen($product)) {
                if ($product == 'exit') {
                    break;
                }
                if (!in_array(strtolower($product), $this->arAvailablesProduct)) {
                    print_r("Введен недопустимый продукт!" . PHP_EOL);
                } else {
                    $ingredients = trim(readline('Какой ингредиент вы ходите добавить? [' . implode(", ", $this->arAvailableIngredients) . '] Введите через запятую, либо basic - для стандартного рецепта: '));
                    $arIngredients = $this->prepareIngredients($ingredients);
                    if ($this->checkIngredients($arIngredients)) {
                        CreateOrder::create($product, $arIngredients);
                    }
                }
            }
        }
    }

    private function prepareIngredients(string $ingredients): array
    {
        $result = [];
        $arTmp = explode(",", $ingredients);
        foreach ($arTmp as $oneTmp) {
            $oneTmp = trim($oneTmp);
            if (strlen($oneTmp)) {
                $result[] = $oneTmp;
            }
        }
        return $result;
    }


    private function checkIngredients(array $arIngredients): bool
    {
        if (count($arIngredients) == 1) {
            if ($arIngredients[0] == 'basic') {
                return true;
            }
        }

        foreach ($arIngredients as $oneIngredient) {
            if (!in_array($oneIngredient, $this->arAvailableIngredients)) {
                print_r("Недопустимый ингредиент!" . PHP_EOL);
                return false;
            }
        }
        return true;
    }
}
