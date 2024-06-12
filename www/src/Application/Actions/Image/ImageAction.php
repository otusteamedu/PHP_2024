<?php

declare(strict_types=1);

namespace App\Application\Actions\Image;

use App\Application\Actions\Action;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

abstract class ImageAction extends Action
{
    protected EntityManagerInterface $entityManager;

    public function __construct(
        LoggerInterface        $logger,
        EntityManagerInterface $entityManager,
    )
    {
        parent::__construct($logger);
        $this->entityManager = $entityManager;
    }

}