<?php

namespace App\Infrastructure\Main;

use App\Domain\Repository\BookRepositoryInterface;
use App\Infrastructure\Repository\BookRepositoryCreatorInterface;

interface ApplicationInterface
{
    public function __construct(array $config, BookRepositoryCreatorInterface $bookRepositoryCreator);

    public static function setInstance(self $application): void;

    public static function initApplication(array $config, BookRepositoryCreatorInterface $bookRepositoryCreator): self;

    public static function getInstance(): self;

    public function getBookRepository(): BookRepositoryInterface;
}
