<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Order;
use App\Enum\AdditionIngredientEnum;
use App\Enum\CookingStatusEnum;
use App\Enum\ProductTypeEnum;
use App\Exception\DomainException;
use App\Food\Product\Composite\Burger;
use App\Food\Product\Composite\HotDog;
use App\Food\Product\Composite\Product;
use App\Food\Product\Composite\Sandwich;
use App\Food\Product\Decorator\OnionDecorator;
use App\Food\Product\Decorator\PepperDecorator;
use App\Food\Product\Decorator\SaladDecorator;
use App\Observe\CookingStatusSubject;

class CookingService
{
    public function __construct(private CookingStatusSubject $cookingStatusSubject)
    {
    }

    /** @return Product[]
     * @throws \Exception
     */
    public function cook(Order $order): array
    {
        $this->cookingStatusSubject->setCookingStatus(CookingStatusEnum::WAITING);
        $this->cookingStatusSubject->notify();
        sleep(3);
        $this->cookingStatusSubject->setCookingStatus(CookingStatusEnum::PREPARING);
        $this->cookingStatusSubject->notify();
        sleep(2);

        $this->cookingStatusSubject->setCookingStatus(CookingStatusEnum::COOKING);
        $this->cookingStatusSubject->notify();
        sleep(5);
        $products = [];
        foreach ($order->items as $item) {
            for ($i = 0; $i < $item->quantity; $i++) {
                if ($item->productType === ProductTypeEnum::BURGER) {
                    $product = new Burger();
                } elseif ($item->productType === ProductTypeEnum::HOTDOG) {
                    $product = new HotDog();
                } elseif ($item->productType === ProductTypeEnum::SANDWICH) {
                    $product = new Sandwich();
                } else {
                    throw new DomainException('Unknown product type');
                }

                foreach ($item->additionalIngredients as $ingredient) {
                    if ($ingredient === AdditionIngredientEnum::ONION) {
                        $product = new OnionDecorator($product);
                    } elseif ($ingredient === AdditionIngredientEnum::SALAD) {
                        $product = new SaladDecorator($product);
                    } elseif ($ingredient === AdditionIngredientEnum::PEPPER) {
                        $product = new PepperDecorator($product);
                    } else {
                        throw new DomainException('Unknown ingredient');
                    }
                }

                $products[] = $product;
            }
        }

        $this->cookingStatusSubject->setCookingStatus(CookingStatusEnum::COOKED);
        $this->cookingStatusSubject->notify();

        return $products;
    }
}
