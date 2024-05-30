<?php


namespace App\controllers;


use App\main\AppCall;

class UserAuthController extends UserController
{
    protected $defaultAction = "one";
    public $nameSingle = "userAuth";
    public $namePlr = "usersAuth";

    public function getRepository()
    {
        return AppCall::call()->userAuthRepository;
    }

    public function getService()
    {
        return AppCall::call()->userService;
    }

    public function run($action)
    {
        if (empty($this->request->session("user"))) {
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

    public function allAction()
    {
        return $this->render("$this->namePlr", [
            "$this->namePlr" => $this->repository->getAll(),
            'id_user' => $this->request->session("user")
        ]);
    }


}