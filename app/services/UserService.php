<?php


namespace App\services;


class UserService extends CRUDService
{

    public function hasErrors($params)
    {
        if (empty($params['login']) || empty($params['password'])) {
            return true;
        }

        return false;
    }
}