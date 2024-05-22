<?php

declare(strict_types=1);

namespace App\Application\Actions\Category;

use App\Application\Actions\Action;
use App\Domain\Category\CategoryRepository;
use Psr\Log\LoggerInterface;

abstract class CategoryAction extends Action
{
    protected CategoryRepository $categoryRepository;

    public function __construct(LoggerInterface $logger, CategoryRepository $categoryRepository)
    {
        parent::__construct($logger);
        $this->categoryRepository = $categoryRepository;
    }
}