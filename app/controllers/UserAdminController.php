<?php

namespace App\controllers;


use App\main\AppCall;

class UserAdminController extends CRUDController
{
    public $nameSingle = "userAdmin";
    public $namePlr = "usersAdmin";
    protected $defaultAction = "one";

    public function getRepository()
    {
        return AppCall::call()->userAdminRepository;
    }

    public function getService()
    {
        return AppCall::call()->userService;
    }

    public function run($action)
    {
        if ($this->request->session("role") != 1) {
            return header('Location: /auth');
        }
        return parent::run($action);
    }

    public function oneAction()
    {
        return $this->render("$this->nameSingle", [
            "$this->nameSingle" => $this->repository->getOne($this->request->session("user")),
            'id_user' => $this->request->session("user")

        ]);
    }
}