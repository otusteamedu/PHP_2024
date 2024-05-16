<?php

declare(strict_types=1);

namespace App\Layer\Application\UseCase;

use App\Layer\Application\UseCase\Request\CreateNewOrderRequest;
use App\Layer\Application\UseCase\Response\CreateNewOrderResponse;
use App\Layer\Domain\Entity\Order\Order;
use App\Layer\Domain\Entity\Product\Product;
use App\Layer\Domain\Entity\Product\ProductAdapter\Pizza;
use App\Layer\Domain\Entity\Product\ProductAdapter\PizzaAdapter;
use App\Layer\Domain\Entity\Product\ProxyStrategyProduct\ProxyProduct;

class CreateNewOrderUseCase
{
    private CreateOrderResponseInterface $response;
    public function __construct(CreateOrderResponseInterface $response)
    {
       $this->response = $response;
    }
    public function __invoke(CreateNewOrderRequest $request): CreateNewOrderResponse
    {
        $order = new Order();

        foreach ($request->request->all()['order']['product'] as $product) {
            $strategy_product = "App\Layer\Domain\Entity\Product\\" . $product;

            //$object = new ProxyProduct(new $strategy_product);

            $object = new Product(new $strategy_product());

            $object->createNewProduct();
            $object->setName();
            $object->addStatusProduct();
            $object->calcPrice();
            $order->setChildItem($object);
        }

        $pizza = new PizzaAdapter(new Pizza());
        $pizza->createNewProduct();
        $pizza->setName();
        $pizza->addStatusProduct();
        $pizza->calcPrice();

        $order->setChildItem($pizza); // пицца получилась за счет заведения =)

        $order->calcPrice();

        return new CreateNewOrderResponse
        (
            $this->response->getResponse($order)
        );
    }
}
