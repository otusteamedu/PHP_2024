<?php

namespace App\Application\Interface;

use App\Domain\Entity\OrderEntity;

interface Repository
{
    public function save(OrderEntity $order);

    public function updateOrderStatus($orderId, $status);

    public function getCurType(string $cur);

    public function getRowsOrderWhere(string $field, string $value);
    public function getRowsOrderWhereCurfromIsCrypto(string $field, string $value);

}
