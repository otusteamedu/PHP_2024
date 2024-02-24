<?php

namespace Pavelsergeevich\Hw6\Core;

use \ReflectionClass;
use \Pavelsergeevich\Hw6\Core;

abstract class Controller
{
    const CONTROLLERS_NAMESPACE = '\\Pavelsergeevich\\Hw6\\Controllers\\';
    const CONTROLLERS_ENDING = 'Controller';
    const ACTION_ENDING = 'Action';
    public array $routeParams;
    public Core\View $view;
    public Core\Model $model;
    public array $requestParams;

    /**
     * @throws \Exception
     */
    public function __construct($routeParams) {

        $this->routeParams = $routeParams;
        if (!$this->checkAllow()) {
            throw new \Exception('Недостаточно прав для просмотра данной страницы');
        }

        $this->requestParams = ['get' => $_GET,'post' => $_POST, 'all' => $_REQUEST];
        $this->model = $this->getModel($this->routeParams, $this->requestParams);
        $this->view = $this->getView($this->routeParams);
    }

    /**
     * @throws \Exception
     */
    protected function getView(array $routeParams, ?array $additionalParams = []): Core\View
    {
        return new Core\View($routeParams);
    }

    protected function getModel(array $routeParams, ?array $requestParams = [], ?array $additionalParams = []): Core\Model
    {
        $modelClass = Core\Model::MODELS_NAMESPACE . $routeParams['controller'] . Core\Model::MODELS_ENDING;
        if (!class_exists($modelClass)) {
            throw new \Exception('Не найденa модель: ' . $modelClass, 500);
        }
        return new $modelClass($requestParams, $additionalParams);
    }

    protected function checkAllow(): bool
    {
        return true;
    }
}