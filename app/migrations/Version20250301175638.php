<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250301175638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE request_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE requests 
        (
            id          bigserial    NOT NULL,
            requester_name VARCHAR(255) NOT NULL, 
            requester_email VARCHAR(255) NOT NULL, 
            status VARCHAR(255) NOT NULL,
            CONSTRAINT requests_pkey PRIMARY KEY (id)
        )');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE request_id_seq CASCADE');
        $this->addSql('DROP TABLE requests');
    }
}
