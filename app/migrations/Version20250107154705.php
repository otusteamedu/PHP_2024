<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250107154705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE  transaction_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE  transaction_type 
        (
            id          bigserial    NOT NULL,
            title VARCHAR(255) NOT NULL, 
            slug VARCHAR(255) NOT NULL, 
            CONSTRAINT transaction_type_pkey PRIMARY KEY (id)
        )');
        $this->addSql("INSERT INTO public.transaction_type (title, slug ) 
                    VALUES('Пополнение', 'pay'),
                          ('Снятие', 'charge');");

        $this->addSql('CREATE SEQUENCE  transactions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE  transactions
        (
            id          bigserial    NOT NULL,
            amount int  NOT NULL, 
            description VARCHAR(255) NOT NULL, 
            transaction_type_id  bigserial    NOT NULL,
            account_id  bigserial    NOT NULL,
            created_at timestamp NOT NULL,
            CONSTRAINT transactions_pkey PRIMARY KEY (id),
            CONSTRAINT  transaction_type_transactions_fk FOREIGN KEY (transaction_type_id) REFERENCES transaction_type (id) ON DELETE RESTRICT ON UPDATE CASCADE,
             CONSTRAINT  account_transactions_fk FOREIGN KEY (account_id) REFERENCES accounts (id) ON DELETE RESTRICT ON UPDATE CASCADE
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE transactions_id_seq CASCADE');
        $this->addSql('DROP TABLE transactions');
        $this->addSql('DROP SEQUENCE transaction_type_id_seq CASCADE');
        $this->addSql('DROP TABLE transaction_type');
    }
}
