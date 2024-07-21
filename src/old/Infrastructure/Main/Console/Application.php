<?php

declare(strict_types=1);

namespace App\old\Infrastructure\Main\Console;

use App\old\Infrastructure\Action\BookSearchAction;

class Application extends \App\old\Infrastructure\Main\AbstractApplication
{
    private $action;

    public function initAction($option)
    {
        if (empty($option['action'])) {
            throw new \Exception('Не передано действие');
        }

        if ($option['action'] == 'search') {
            $this->action = new BookSearchAction();
        } else {
            throw new \Exception('Передано не существующие действие');
        }
    }

    public function getActionAvailableOptions()
    {
        return $this->action->getAvailableOptions();
    }

    public static function initApplication(array $config = []): self
    {
        $application = new self($config);
        self::setInstance($application);
        return $application;
    }

    public function runAction(array $options = [])
    {
        $this->action->exec($options);
    }
}
