<?php

declare(strict_types=1);

namespace App\Application\Actions\Image;

use App\Domain\Image\Image;
use App\Domain\Image\Status;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Psr\Http\Message\ResponseInterface as Response;

class GetImage extends ImageAction
{

    protected function action(): Response
    {
        $id = $this->resolveArg('id');
        try {
            $image = $this->entityManager->find(Image::class, $id);
        } catch (ORMException $e) {
            throw new \Exception("Image not found");
        }

        return $this->respondWithData($image);
    }
}