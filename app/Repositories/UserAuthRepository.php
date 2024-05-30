<?php


namespace App\Repositories;


use App\controllers\CRUDController;
use App\entities\User;
use App\entities\UserAuth;
use App\main\AppCall;

class UserAuthRepository extends Repository
{
    /**
     * @inheritDoc
     */
    public function getTableName(): string
    {
        return 'users';
    }

    /**
     * @inheritDoc
     */
    public function getEntityClass(): string
    {
        return  UserAuth::class;
    }

    public function getRepositoryClass():object
    {
        return AppCall::call()->userAuthRepository;
    }
}