<?php


namespace App\Repositories;


use App\entities\Basket;
use App\entities\Entity;
use App\main\AppCall;
use App\services\CRUDService;
use App\services\Request;

class BasketRepository extends Repository
{
    protected $sessionName;

    /**
     * @return  string with session name
     */

    public function getTableName(): string
    {
        return "order_list";
    }

    /**
     * @return string with entity class name
     */
    public function getEntityClass(): string
    {
        return Basket::class;
    }

    /**
     * @inheritDoc
     */
    public function getRepositoryClass()
    {
        AppCall::call()->basketRepository;
    }

    public function getProductsInBasket(Request $request)
    {
        return $request->session($this->getTableName());
    }

    public function getProductInBasket($id, $request)
    {
        $products = $this->getProductsInBasket($request);
        if (empty($products["$id"])) {
            return null;
        }
        return $products["$id"];

    }

    public function addNew($product, $request)
    {
        $request->setSession($this->getTableName(), $product, $product["goods_id"]);
    }

    public function changeCount($product, $request, $count)
    {
        $product["count"] = $product["count"] + $count;
        $this->addNew($product, $request);
    }

    public function add($product, $request)
    {
        if (empty($this->getProductInBasket($product["goods_id"], $request))) {
            $product["count"] = 1;
            $this->addNew($product, $request);
        } else {
            $this->changeCount($product, $request, 1);
        }

    }

    public function deleteProduct($id, Request $request)
    {

        $item = $this->getProductInBasket($id, $request);
        if ($item["count"] > 1) {
            $this->changeCount($item, $request, -1);
        } else {

            $request->unsetInSession($this->getTableName(), $id);

        }

    }

    public function getSummary($products)
    {
        $total = 0;

        foreach ($products as $idProduct => $product) {
            $totalGoodPrice = (int)$product['count'] * (int)$product['price_product'];
            $total += $totalGoodPrice;
        }

        return $total;
    }

    public function getProductsObjects($request)
    {
        $products = $this->getProductsInBasket($request);
        return (object)$products;
    }

    public function saveProductsAction($request, CRUDService $service, $repository)
    {
        $products = $this->getProductsObjects($request);
        foreach ($products as $product) {
            $service->fill($product, $repository, $request);
            $this->insert($product);
        }
    }


}