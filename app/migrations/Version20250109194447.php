<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250109194447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE statements_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE statements (
          id INT NOT NULL,
          account_id INT NOT NULL,
          date_from TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          date_to TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          status VARCHAR(255) NOT NULL,
          
         CONSTRAINT statements_pkey PRIMARY KEY (id),
         CONSTRAINT  statements_accounts_fk FOREIGN KEY (account_id) REFERENCES accounts (id) ON DELETE RESTRICT ON UPDATE CASCADE
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE statements_id_seq CASCADE');
        $this->addSql('DROP TABLE statements');
    }
}
