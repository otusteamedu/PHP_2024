<?php


namespace App\Repositories;


use App\entities\Good;
use App\main\AppCall;

class GoodRepository extends Repository
{

    /**
     * @return string with table name
     */
    public function getTableName(): string
    {
        return "goods";
    }

    /**
     * @return string with entity class name
     */
    public function getEntityClass(): string
    {
        return Good::class;
    }

    public function getRepositoryClass(): object
    {
        return AppCall::call()->goodRepository;
    }
}