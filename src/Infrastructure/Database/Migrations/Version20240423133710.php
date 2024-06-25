<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240423133710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Создает таблицу для хранения новостей';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE news_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql(
            'CREATE TABLE news (
                                id INT NOT NULL,
                                created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
                                title VARCHAR(255) NOT NULL,
                                url TEXT NOT NULL,
                                PRIMARY KEY(id)
                  )'
        );
        $this->addSql('COMMENT ON COLUMN news.created_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE news_id_seq CASCADE');
        $this->addSql('DROP TABLE news');
    }
}
