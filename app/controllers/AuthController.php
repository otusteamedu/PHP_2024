<?php


namespace App\controllers;


class AuthController extends Controller
{
    protected $defaultAction = 'login';

    public function loginAction()
    {
        if ($this->isPost()) {
            $login = $this->request->post("login");
            $password = $this->request->post("password");
            if (empty($login)&&($password)) {
                header("location:/auth/login");
            }
            $this->request->setSession("user", $login, "login");
            $this->request->setSession("user", $password, "password");
            header("location:/user/auth");

        }else{
            return $this->render("login");
        }



    }

    public function logOutAction()
    {
        session_destroy();
        $this->request->unsetInSession("user");
        $this->request->unsetInSession("role");
        return header('Location: /auth');
    }

}