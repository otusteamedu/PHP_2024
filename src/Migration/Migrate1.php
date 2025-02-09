<?php

namespace KRudenko\Otus\Migration;

use KRudenko\Otus\Database\Connection;
use PDO;

class Migrate1
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connection::get();
    }

    public function up(): void
    {
        $this->pdo->exec('DROP TABLE IF EXISTS "user"');
        $this->pdo->exec('CREATE TABLE IF NOT EXISTS "user" (id serial PRIMARY KEY, name character varying(255) NOT NULL, email character varying(255) NOT NULL UNIQUE)');
        $this->pdo->exec("INSERT INTO \"user\" (name, email) VALUES ('test', 'test@test.test')");
    }

    public function down(): void
    {
        $this->pdo->exec('DROP TABLE IF EXISTS "user"');
    }
}
