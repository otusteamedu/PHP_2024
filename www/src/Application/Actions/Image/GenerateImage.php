<?php

declare(strict_types=1);

namespace App\Application\Actions\Image;

use App\Application\DTO\ImageDTO;
use App\Application\Queue\MessageDTO;
use App\Application\Queue\QueueInterface;
use App\Domain\Image\Image;
use App\Domain\Image\ImageStorageInterface;
use App\Domain\Image\Status;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;

class GenerateImage extends ImageAction
{
    protected function action(): Response
    {
        $data = $this->getFormData();

        try {
            $description = $data['description'];
        } catch (\Exception $e) {
            throw new \Exception("Description required in body");
        }

        $image = $this->imageStorage->generateImageByDescription($description);

        return $this->respondWithData(new ImageDTO(
            $image->getId(),
            $image->getDescription(),
            null
        ));
    }
}
