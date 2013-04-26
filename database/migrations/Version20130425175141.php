<?php

namespace TravisDoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130425175141 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE album CHANGE length length smallint unsigned");
        $this->addSql("ALTER TABLE album_artist DROP FOREIGN KEY FK_D322AB30B7970CF8");
        $this->addSql("ALTER TABLE album_artist DROP FOREIGN KEY FK_D322AB301137ABCF");
        $this->addSql("ALTER TABLE album_artist ADD CONSTRAINT FK_D322AB30B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE album_artist ADD CONSTRAINT FK_D322AB301137ABCF FOREIGN KEY (album_id) REFERENCES album (id) ON DELETE CASCADE");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE album CHANGE length length SMALLINT UNSIGNED DEFAULT NULL");
        $this->addSql("ALTER TABLE album_artist DROP FOREIGN KEY FK_D322AB301137ABCF");
        $this->addSql("ALTER TABLE album_artist DROP FOREIGN KEY FK_D322AB30B7970CF8");
        $this->addSql("ALTER TABLE album_artist ADD CONSTRAINT FK_D322AB301137ABCF FOREIGN KEY (album_id) REFERENCES album (id)");
        $this->addSql("ALTER TABLE album_artist ADD CONSTRAINT FK_D322AB30B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)");
    }
}
