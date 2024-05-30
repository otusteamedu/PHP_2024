<?php


namespace App\Repositories;


use App\entities\Good;
use App\entities\GoodAuth;
use App\main\AppCall;

class GoodAuthRepository extends Repository
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
        return GoodAuth::class;
    }

    public function getRepositoryClass(): object
    {
        return AppCall::call()->goodAuthRepository;
    }
}