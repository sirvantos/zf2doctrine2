<?php

namespace TravisDoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130424160212 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE album_artist (album_id integer unsigned, artist_id integer unsigned, INDEX IDX_D322AB301137ABCF (album_id), INDEX IDX_D322AB30B7970CF8 (artist_id), PRIMARY KEY(album_id, artist_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE album_artist ADD CONSTRAINT FK_D322AB301137ABCF FOREIGN KEY (album_id) REFERENCES album (id)");
        $this->addSql("ALTER TABLE album_artist ADD CONSTRAINT FK_D322AB30B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)");
        $this->addSql("ALTER TABLE artist CHANGE id id integer unsigned");
        $this->addSql("ALTER TABLE album CHANGE id id integer unsigned, CHANGE length length smallint unsigned");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE album_artist");
        $this->addSql("ALTER TABLE album CHANGE id id INT UNSIGNED DEFAULT 0 NOT NULL, CHANGE length length SMALLINT UNSIGNED DEFAULT NULL");
        $this->addSql("ALTER TABLE artist CHANGE id id INT UNSIGNED DEFAULT 0 NOT NULL");
    }
}
