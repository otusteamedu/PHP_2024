<?php


namespace App\Repositories;


use App\entities\Order;
use App\entities\OrderAdmin;
use App\main\AppCall;

class OrderAdminRepository extends OrderRepository
{
    /**
     * @return string with table name
     */
    public function getTableName(): string
    {
        return 'orders';
    }

    /**
     * @inheritDoc
     */
    public function getEntityClass(): string
    {
        return OrderAdmin::class;
    }
    public function getRepositoryClass():object
    {
        return AppCall::call()->orderAdminRepository;
    }

    public function updateOrderList($entity)
    {
        $allDataToInsert = [];
        $allValues = [];

        foreach ($entity as $data => $value) {

            if ($data == 'goods_id'|| $data == 'order_id') {
                $allValues[":${data}"] = $value;
                continue;
            }
            $allValues[":${data}"] = $value;
            $allDataToInsert[] = "${data} = :{$data}";

        }

        $strToSetUpdate = implode(", ", $allDataToInsert);

        $sql = "UPDATE  order_list SET  {$strToSetUpdate} WHERE order_id = :order_id AND goods_id = :goods_id";

        return $this->bd->execute($sql, $allValues);

    }

}