<?php


namespace App\controllers;

use App\exceptions\AddressNotFoundException;
use App\services\renders\IRender;
use App\services\renders\TmpRender;
use App\services\Request;

abstract class Controller
{
    protected $defaultAction = 'all';
    protected $render;
    protected $request;


    public function __construct(IRender $render, Request $request)
    {
        $this->render = $render;
        $this->request = $request;
    }

    public function run($actionName)
    {

        if (empty($actionName)) {
            $actionName = $this->defaultAction;
        }

        $method = $actionName . 'Action';

        if (method_exists($this, $method)) {

            return $this->$method();
        }
        try {
            if (method_exists($this, $method)) {

                return $this->$method();
            }

            throw new AddressNotFoundException();

        } catch (AddressNotFoundException $e) {

            return ($this->render)->render('error');
        }
    }

    protected function render($template, $params = [])
    {
        return $this->render->render($template, $params);
    }

    public function getId()
    {
        return (int)$this->request->get('id');
    }

    protected function isPost()
    {
        return $this->request->isPost();
    }


}