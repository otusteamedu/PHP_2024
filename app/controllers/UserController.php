<?php


namespace App\controllers;

use App\main\AppCall;
use App\modules\User;


class UserController extends CRUDController
{
    public $nameSingle = "user";
    public $namePlr = "users";


    public function getRepository()
    {
        return AppCall::call()->userRepository;
    }

    public function getService()
    {
        return AppCall::call()->userService;
    }

    public function authAction()
    {
        $user = $this->repository->getOneByLogin($this->request->session("user", "login"));
        if ($user) {
            $passwordGiven = ($this->request->session("user", "password"));
            $this->request->unsetInSession("user", "password");
            $this->request->unsetInSession("user", "login");
            if (password_verify((string)$passwordGiven, $user->password)) {
                $this->request->setSession("user", $user->id);
                if ($user->role == 1) {
                    $this->request->setSession("role", "1");
                }
            }
        }
        header("location:/");
    }


    public function allAction()
    {
        header("location:/auth");
    }

    public function oneAction()
    {
        header("location:/auth");
    }



}