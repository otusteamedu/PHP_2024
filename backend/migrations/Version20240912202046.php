<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240912202046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create news table';
    }

    public function up(Schema $schema): void
    {
        // Создание таблицы news
        $this->addSql('CREATE TABLE news (
            id SERIAL PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            url VARCHAR(255) NOT NULL,
            date TIMESTAMP NOT NULL
        )');
    }

    public function down(Schema $schema): void
    {
        // Удаление таблицы news
        $this->addSql('DROP TABLE news');
    }
}
