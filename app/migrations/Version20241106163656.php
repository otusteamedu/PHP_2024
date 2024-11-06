<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241106163656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $query = <<<SQL
            CREATE TABLE media_monitoring_reports(
                id SERIAL NOT NULL, 
                type VARCHAR(255) NOT NULL, 
                path VARCHAR(255) NOT NULL, 
                PRIMARY KEY(id)
            )
         SQL;

        $this->addSql($query);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE media_monitoring_reports');
    }
}
