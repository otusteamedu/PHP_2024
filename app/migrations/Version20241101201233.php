<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241101201233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $query = <<<SQL
            CREATE TABLE media_monitoring_posts(
                id INT NOT NULL, 
                title VARCHAR(255) NOT NULL, 
                date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, 
                url VARCHAR(255) NOT NULL, 
                PRIMARY KEY(id)
            )
        SQL;

        $this->addSql($query);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE media_monitoring_posts');
    }
}
