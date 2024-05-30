<?php


namespace App\Repositories;


use App\entities\GoodAdmin;
use App\main\AppCall;

class GoodAdminRepository extends Repository
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
        return GoodAdmin::class;
    }

    /**
     * @return object repository class
     */
    public function getRepositoryClass()
    {
        return AppCall::call()->goodAdminRepository;
    }
}