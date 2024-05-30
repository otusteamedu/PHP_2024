<?php


namespace App\Repositories;


use App\entities\User;
use App\main\AppCall;

class UserRepository extends Repository
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
        return  User::class;
    }

    public function getRepositoryClass():object
    {
        return AppCall::call()->userRepository;
    }

    public function getOneByLogin($login)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE login = :login";
        return $this->bd->queryObj($sql, $this->getEntityClass(), [':login' => "$login"]);
    }
}