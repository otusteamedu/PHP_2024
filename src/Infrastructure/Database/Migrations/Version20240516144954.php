<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240516144954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Создал таблицы плейлистов, треков и связей между ними';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE playlist_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE track_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE playlist (id INT NOT NULL, user_email VARCHAR(60) NOT NULL, name VARCHAR(60) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE playlist_track (playlist_id INT NOT NULL, track_id INT NOT NULL, PRIMARY KEY(playlist_id, track_id))');
        $this->addSql('CREATE INDEX IDX_75FFE1E56BBD148 ON playlist_track (playlist_id)');
        $this->addSql('CREATE INDEX IDX_75FFE1E55ED23C43 ON playlist_track (track_id)');
        $this->addSql('CREATE TABLE track (id INT NOT NULL, name VARCHAR(60) NOT NULL, author VARCHAR(60) NOT NULL, genre VARCHAR(60) NOT NULL, duration INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE playlist_track ADD CONSTRAINT FK_75FFE1E56BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE playlist_track ADD CONSTRAINT FK_75FFE1E55ED23C43 FOREIGN KEY (track_id) REFERENCES track (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE playlist_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE track_id_seq CASCADE');
        $this->addSql('ALTER TABLE playlist_track DROP CONSTRAINT FK_75FFE1E56BBD148');
        $this->addSql('ALTER TABLE playlist_track DROP CONSTRAINT FK_75FFE1E55ED23C43');
        $this->addSql('DROP TABLE playlist');
        $this->addSql('DROP TABLE playlist_track');
        $this->addSql('DROP TABLE track');
    }
}
