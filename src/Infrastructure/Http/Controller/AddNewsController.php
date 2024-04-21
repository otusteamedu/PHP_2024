<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\Request\AddNewsRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddNewsController extends  AbstractController
{
    public function __invoke(AddNewsRequest $request)
    {
        // TODO: Implement __invoke() method.
    }
}
