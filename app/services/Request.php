<?php

namespace App\services;


class Request
{
    protected $requestString;
    protected $controllerName;
    protected $actionName;
    protected $params;
    protected $session;
    protected $files;


    public function __construct()
    {
        session_start();
        $this->requestString = $_SERVER['REQUEST_URI'];
        $this->params = [
            'get' => $_GET,
            'post' => $_POST,
        ];
        $this->files = $_FILES;
        $this->parseRequest();
        $this->session = $_SESSION;

    }

    /**
     * @return mixed
     */
    public function getFiles()
    {
        return $this->files;
    }

    protected function parseRequest()
    {
        $pattern = "#(?P<controller>\w+)[/]?(?P<action>\w+)?[/]?[?]?(?P<params>.*)#ui";
        if (preg_match_all($pattern, $this->requestString, $matches)) {
            $this->controllerName = $matches['controller'][0];
            $this->actionName = $matches['action'][0];

        }
    }

    public function get($params = '', $params2 = '')
    {
        if (empty($params)) {
            return $this->params['get'];
        }

        if (!empty($this->params['get'][$params])) {
            return $this->params['get'][$params];
        }
        if (!empty($this->params['get'][$params][$params2])) {
            return $this->params['get'][$params][$params2];
        }

        return array();
    }

    public function session($param1 = '', $param2 = "")
    {
        if (!empty($this->session[$param1][$param2])) {
            return $this->session[$param1][$param2];
        }


        if (!empty($this->session[$param1])) {
            return $this->session[$param1];
        }

        if (!empty($this->session[$param1])) {
            return $this->session[$param1];
        }

        return array();
    }

    public function setSession($session, $object, $param = "")
    {
        if (!isset($_SESSION[$session])) {
            $_SESSION[$session] = [];
        }
        if (!empty($param)) {
            if (!isset($_SESSION[$session][$param])) {
                $_SESSION[$session][$param] = "";
            } else {
                $_SESSION[$session][$param] = $object;
            }
            $_SESSION[$session][$param] = $object;


        } else {
            $_SESSION [$session] = $object;
        }

    }


    public function post($params = '')
    {
        if (empty($params)) {
            return $this->params['post'];
        }

        if (!empty($this->params['post'][$params])) {
            return $this->params['post'][$params];
        }

        return array();
    }

    /**
     * @return mixed
     */
    public function getRequestString()
    {
        return $this->requestString;
    }

    /**
     * @return mixed
     */
    public function getControllerName()
    {
        return $this->controllerName;
    }

    /**
     * @return mixed
     */
    public function getActionName()
    {
        return $this->actionName;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return mixed
     */
    public function getSession()
    {
        return $this->session;
    }

    public function uploadPic()
    {
        $filename = "";
        if (!empty ($this->files['userfile']['name'])) {
            $file = dirname(__DIR__) . "/public/img/" . $_FILES['userfile']['name'];
            copy($this->files['userfile']['tmp_name'], $file);
            $filename = $this->files['userfile']['name'];
        }

        return $filename;

    }

    public function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] == "POST";
    }


    public function unsetInSession($param1, $param2 = null)
    {
        if (!empty($param2)) {
            unset($_SESSION[$param1][$param2]);
        } else {
            unset($_SESSION[$param1]);
        }

    }
}

