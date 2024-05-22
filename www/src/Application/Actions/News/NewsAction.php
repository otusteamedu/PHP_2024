<?php

declare(strict_types=1);

namespace App\Application\Actions\News;

use App\Application\Actions\Action;
use App\Domain\Category\CategoryRepository;
use App\Domain\News\NewsRepository;
use App\Domain\User\UserRepository;
use Psr\Log\LoggerInterface;

abstract class NewsAction extends Action
{
    protected NewsRepository $newsRepository;
    protected CategoryRepository $categoryRepository;
    protected UserRepository $userRepository;

    public function __construct(
        LoggerInterface $logger,
        NewsRepository $newsRepository,
        CategoryRepository $categoryRepository,
        UserRepository $userRepository,
    )
    {
        parent::__construct($logger);
        $this->newsRepository = $newsRepository;
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
    }
}