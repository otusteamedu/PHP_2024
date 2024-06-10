<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240610073446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Создал таблицу для хранения подписок на жанры';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_genre_subscription (user_email VARCHAR(60) NOT NULL, genre VARCHAR(60) NOT NULL, PRIMARY KEY(user_email, genre))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE user_genre_subscription');
    }
}
