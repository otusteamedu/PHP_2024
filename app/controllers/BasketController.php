<?php


namespace App\controllers;


use App\main\AppCall;


class BasketController extends CRUDController
{
    private $product;
    protected $defaultAction = 'show';

    public function getRepository()
    {
        return AppCall::call()->basketRepository;
    }

    public function getService()
    {
        return AppCall::call()->basketService;
    }

    public function showAction()
    {

        $products = $this->repository->getProductsInBasket($this->request);
        $summary = $this->repository->getSummary($products);
        return $this->render('basket', ['products' => $products,
            'summary' => $summary,
            'id_user' => $this->request->session("user")]);

    }

    public function addAction()
    {
        $id = $this->getId();
        if (empty($this->repository->getProductInBasket($id, $this->request))) {
            $product = $this->service->getProduct($id);
        } else {
            $product = $this->repository->getProductInBasket($id, $this->request);
        }
        $this->repository->add($product, $this->request);
        header('location: ' . $_SERVER['HTTP_REFERER']);

    }

    public function deleteAction()
    {
        $id = $this->getID();
        $this->repository->deleteProduct($id, $this->request);
        header('location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function updateOrderListAction()
    {
        $products = $this->repository->getProductsObjects($this->request);

        foreach ($products as $product) {
            unset($product["name_product"]);
            unset($product["img_dir"]);
            unset($product["description_short"]);

             $this->service->fill((array)$product, $this->repository, $this->request);
        }

        $this->request->unsetInSession("order_list");

        header('location:/orderAuth/');
    }


}