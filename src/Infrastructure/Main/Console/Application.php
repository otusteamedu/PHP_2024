<?php

declare(strict_types=1);

namespace App\Infrastructure\Main\Console;

use App\Application\UseCase\SearchBookUseCase;
use App\Infrastructure\Action\BookSearchAction;
use App\Infrastructure\Repository\BookRepositoryCreatorInterface;

class Application extends \App\Infrastructure\Main\AbstractApplication
{
    private $action;

    public function initAction($option)
    {
        if (empty($option['action'])) {
            throw new \Exception('Не передано действие');
        }

        if ($option['action'] == 'search') {
            $this->action = new BookSearchAction($this->getSearchBookUseCase());
        } else {
            throw new \Exception('Передано не существующие действие');
        }
    }

    public function getActionAvailableOptions()
    {
        return $this->action->getAvailableOptions();
    }

    public static function initApplication(array $config, BookRepositoryCreatorInterface $bookRepositoryCreator): self
    {
        $application = new self($config, $bookRepositoryCreator);
        self::setInstance($application);
        return $application;
    }

    public function runAction(array $options = [])
    {
        $this->action->exec($options);
    }
}
