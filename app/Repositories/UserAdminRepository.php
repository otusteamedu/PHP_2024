<?php


namespace App\Repositories;


use App\entities\User;
use App\entities\UserAdmin;
use App\main\AppCall;

class UserAdminRepository extends UserRepository
{
    /**
     * @return string with class name
     */
    public function getEntityClass(): string
    {
        return  UserAdmin::class;
    }

    /**
     * @return object with repository
     */
    public function getRepositoryClass():object
    {
        return AppCall::call()->userAdminRepository;
    }

}