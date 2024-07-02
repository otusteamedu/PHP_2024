<?php

declare(strict_types=1);


namespace App\Infrastructure\Main\Console;


use App\Infrastructure\Action\BookSearchAction;

class Application extends \App\Infrastructure\Main\AbstractApplication
{
    private $action;

    public function initAction($option)
    {
        if (empty($option['action'])) {
            throw new \Exception('Не передано действие');
        }

        if ($option['action'] == 'search') {
            $this->action = new BookSearchAction();
        }else {
            throw new \Exception('Передано не существующие действие');
        }
    }

    public function getActionAvailableOptions()
    {
        return $this->action->getAvailableOptions();
    }

    public function runAction(array $options = [])
    {
        $this->action->exec($options);
    }

    public function getParam(string $paramName)
    {
        return $this->config[$paramName] ?? null;
    }
}