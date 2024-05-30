<?php


namespace App\controllers;

use App\entities\Entity;
use App\Repositories\Repository;
use App\services\CRUDService;
use App\services\renders\IRender;
use App\services\Request;


/**
 * @property IRender render;
 * @property CRUDService service;
 * @property Repository repository;
 */
abstract class CRUDController extends Controller

{
    protected $nameSingle = "";
    protected $namePlr = "";
    protected $render;
    protected $service;
    protected $repository;

    abstract public function getRepository();

    abstract public function getService();

    /**
     * @param IRender $render
     * @param Request $request
     */

    public function __construct(IRender $render, Request $request)
    {
        parent::__construct($render, $request);
        $this->repository = $this->getRepository();
        $this->service = $this->getService();
    }

    public function allAction()
    {
        return $this->render("$this->namePlr", [
            "$this->namePlr" => $this->repository->getAll(),
            'id_user' => $this->request->session("user")
        ]);
    }

    public function oneAction()
    {

        return $this->render("$this->nameSingle", [
            "$this->nameSingle" => $this->repository->getOne($this->getId()),
            'id_user' => $this->request->session("user")

        ]);
    }

    public function addToDBAction()
    {
        if ($this->isPost()) {
            ($this->service)->fill($this->request->post(), $this->repository, $this->request);
            return header("Location:/$this->nameSingle");
        }

        return $this->render($this->nameSingle . "Add");
    }

    public function updateAction()
    {
        if (empty($this->getId())) {
            return header("Location: /$this->nameSingle");
        }

        $item = $this->repository->getOne($this->getId());

        if ($this->isPost()) {
            $this->service->fill($this->request->post(), $this->repository, $this->request, $item);
            return header("Location: /$this->nameSingle");
        }

        return $this->render($this->nameSingle . 'Update', [$this->nameSingle => $item]);
    }

    public function deleteFromDBAction()
    {
        if ($id = $this->getId()) {
            $this->service->delete($id, $this->repository);
        }
        header("location:/" . $this->nameSingle);
    }


    protected function render($template, $params = [])
    {
        return $this->render->render($template, $params);
    }


}