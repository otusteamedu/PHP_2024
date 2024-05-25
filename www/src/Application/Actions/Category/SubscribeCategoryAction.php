<?php

declare(strict_types=1);

namespace App\Application\Actions\Category;

use App\Application\Actions\Action;
use App\Domain\Category\CategoryRepository;
use App\Domain\User\UserRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class SubscribeCategoryAction extends Action
{
    private CategoryRepository $categoryRepository;
    private UserRepository $userRepository;

    public function __construct(
        LoggerInterface $logger,
        CategoryRepository $categoryRepository,
        UserRepository $userRepository
    ) {
        parent::__construct($logger);
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
    }

    protected function action(): Response
    {
        $session = $this->request->getAttribute('session');
        $categoryId = (int) $this->resolveArg('category_id');

        $user = $this->userRepository->findById($session['username']);
        $category = $this->categoryRepository->findById($categoryId);

        $category->addObserver($user);
        $category = $this->categoryRepository->updateSubscribers($category);

        return $this->respondWithData($category);
    }
}