<?php


namespace App\Repositories;


use App\entities\Order;
use App\main\AppCall;

class OrderRepository extends Repository
{

    /**
     * @return string with table name
     */
    public function getTableName(): string
    {
        return 'orders';
    }

    /**
     * @return string with entity class name
     */
    public function getEntityClass(): string 
    {
        return Order::class;
    }
    public function getRepositoryClass():object
    {
        return AppCall::call()->orderRepository;
    }


    public function getOrder($id)
    {
        $order = $this->getOne($id);

        $sql = "SELECT order_list.goods_id as goods_id,
                        goods.name_product as name_product,
                        goods.price_product as price_product,
                        order_list.count as amount,
                        (order_list.count * goods.price_product) as total_price
                        
                FROM orders 
                LEFT JOIN order_list ON order_list.order_id = orders.id
                lEFT JOIN goods ON order_list.goods_id = goods.id
                WHERE 
                    orders.id = :id";


        $order_list = ($this->bd->findAll($sql, [':id' => $id]));
        $order->order_list = $order_list;
        $order->summary = $order->getSummary();
        return $order;
    }


}