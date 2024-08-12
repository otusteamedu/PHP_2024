<?php

declare(strict_types=1);

namespace App\Migration;

class CreateRequestProcessTableMigration extends AbstractMigration
{
    public function up(): void
    {
        $connect = $this->databaseProvider->getConnection();
        $connect->query(
            "CREATE TABLE IF NOT EXISTS 
                request_process (
                    id BIGSERIAL PRIMARY KEY NOT NULL,
                    uuid UUID DEFAULT NULL
            );"
        )->execute();
    }

    public function down(): void
    {
        $connect = $this->databaseProvider->getConnection();
        $connect->query("DROP TABLE IF EXISTS request_process;")->execute();
    }
}
