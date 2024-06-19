<?php
declare(strict_types=1);

namespace App\Infrastructure\Repository;

readonly class InitDb
{
    public string $host;
    public string $db;
    public string $user;
    public string $password;

    public function __construct()
    {
        $this->host = getenv("POSTGRES_HOST");
        $this->db = getenv("POSTGRES_DATABASE");
        $this->user = getenv("POSTGRES_USER");
        $this->password = getenv("POSTGRES_PASSWORD");
    }

}