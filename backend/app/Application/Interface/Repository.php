<?php

namespace App\Application\Interface;

use App\Domain\Entity\OrderEntity;

interface Repository
{
    public function save(string $table,array $data);

    public function saveOrder(OrderEntity $order);

    public function updateOrderStatus($orderId, $status);

    public function getCurType(string $cur);

    public function getRowsOrderWhereCurfromIsCrypto(string $field, string $value);

    public function getRowsWhere(string $table, string $field, mixed $value);

    public function updateRow(string $table, int $id, array $data);

}
