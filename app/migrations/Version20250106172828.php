<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250106172828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE account_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE accounts 
        (
            id          bigserial    NOT NULL,
            holder_name VARCHAR(255) NOT NULL, 
            holder_email VARCHAR(255) NOT NULL, 
            created_at timestamp NOT NULL,
            CONSTRAINT accounts_pkey PRIMARY KEY (id)
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE account_id_seq CASCADE');
        $this->addSql('DROP TABLE accounts');

    }
}
