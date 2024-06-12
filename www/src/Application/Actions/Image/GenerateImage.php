<?php

declare(strict_types=1);

namespace App\Application\Actions\Image;

use App\Application\ImageGenerator\ImageGeneratorInterface;
use App\Application\Queue\MessageDTO;
use App\Application\Queue\QueueInterface;
use App\Domain\Image\Image;
use App\Domain\Image\Status;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;

class GenerateImage extends ImageAction
{
    private QueueInterface $queue;

    public function __construct(
        LoggerInterface $logger,
        EntityManagerInterface $entityManager,
        QueueInterface $queue,
    )
    {
        parent::__construct($logger, $entityManager);
        $this->queue = $queue;
    }


    protected function action(): Response
    {
        $data = $this->getFormData();

        try {
            $description = $data['description'];
        } catch (\Exception $e) {
            throw new \Exception("Description required in body");
        }

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

        return $this->respondWithData();
    }
}