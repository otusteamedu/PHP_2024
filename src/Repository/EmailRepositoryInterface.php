<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Email;
use Exception;

interface EmailRepositoryInterface
{
    public function findOneById(string $id): ?Email;

    /**
     * @throws Exception
     */
    public function save(Email $email): void;
}
