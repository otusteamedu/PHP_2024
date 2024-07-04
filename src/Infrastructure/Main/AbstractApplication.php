<?php

declare(strict_types=1);

namespace App\Infrastructure\Main;

use App\Application\UseCase\SearchBookUseCase;
use App\Domain\Repository\BookRepositoryInterface;
use App\Infrastructure\Main\ApplicationInterface;
use App\Infrastructure\Repository\BookRepositoryCreatorInterface;
use Dotenv\Repository\RepositoryInterface;

abstract class AbstractApplication implements ApplicationInterface
{
    protected static $instance;
    protected array $config;

    protected SearchBookUseCase $searchBookUseCase;

    public function getSearchBookUseCase(): SearchBookUseCase
    {
        return $this->searchBookUseCase;
    }
    protected BookRepositoryInterface $bookRepository;
    protected BookRepositoryCreatorInterface $bookRepositoryCreator;

    public function __construct(array $config, BookRepositoryCreatorInterface $bookRepositoryCreator)
    {
        $this->config = $config;
        $this->bookRepositoryCreator = $bookRepositoryCreator;
        $this->bookRepository = $this->bookRepositoryCreator->createRepository($this->config);
        $this->searchBookUseCase = new SearchBookUseCase($this->bookRepository);
    }

    public function getBookRepository(): BookRepositoryInterface
    {
        return $this->bookRepository;
    }

    public static function setInstance(ApplicationInterface $application): void
    {
        self::$instance = $application;
    }

    public static function getInstance(): self
    {
        if (empty(self::$instance)) {
            throw new \Exception("Application instance not set");
        }

        return self::$instance;
    }

    public function getParam(string $paramName)
    {
        return $this->config[$paramName] ?? null;
    }
}
