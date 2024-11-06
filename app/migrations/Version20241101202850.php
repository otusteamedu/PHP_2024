<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241101202850 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE media_monitoring_posts_id_seq');
        $this->addSql('SELECT setval(\'media_monitoring_posts_id_seq\', (SELECT MAX(id) FROM media_monitoring_posts))');
        $this->addSql('ALTER TABLE media_monitoring_posts ALTER id SET DEFAULT nextval(\'media_monitoring_posts_id_seq\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE media_monitoring_posts ALTER id DROP DEFAULT');
    }
}
