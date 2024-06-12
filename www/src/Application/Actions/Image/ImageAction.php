<?php

declare(strict_types=1);

namespace App\Application\Actions\Image;

use App\Application\Actions\Action;
use App\Domain\Image\ImageStorageInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

abstract class ImageAction extends Action
{
    protected EntityManagerInterface $entityManager;
    protected ImageStorageInterface $imageStorage;

    public function __construct(
        LoggerInterface $logger,
        EntityManagerInterface $entityManager,
        ImageStorageInterface $imageStorage,
    ) {
        parent::__construct($logger);
        $this->entityManager = $entityManager;
        $this->imageStorage = $imageStorage;
    }
}
