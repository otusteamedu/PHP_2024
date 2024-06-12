<?php

declare(strict_types=1);

namespace App\Infrastructure\Storage;

use App\Application\Queue\MessageDTO;
use App\Application\Queue\QueueInterface;
use App\Domain\Image\Image;
use App\Domain\Image\ImageStorageInterface;
use App\Domain\Image\Status;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

class ImageStorage implements ImageStorageInterface
{
    private EntityManagerInterface $entityManager;
    private QueueInterface $queue;

    public function __construct(
        EntityManagerInterface $entityManager,
        QueueInterface $queue,
    ) {
        $this->entityManager = $entityManager;
        $this->queue = $queue;
    }

    public function getImage(string $id): ?Image
    {
        return $this->entityManager->find(Image::class, $id);
    }

    public function generateImageByDescription(string $description): Image
    {
        $id = Uuid::uuid4()->toString();

        $image = new Image(
            $description,
            Status::GENERATING->value,
            $id
        );

        $this->entityManager->persist($image);
        $this->entityManager->flush();

        $this->queue->pushMessage(new MessageDTO(
            $image->getId(),
            $image->getDescription(),
        ));

        return  $image;
    }
}
