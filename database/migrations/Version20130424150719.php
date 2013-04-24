<?php

namespace TravisDoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130424150719 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE album CHANGE id id integer unsigned, CHANGE length length smallint unsigned");
        $this->addSql("CREATE INDEX album_title_idx ON album (title)");
        $this->addSql("CREATE INDEX album_length_idx ON album (length)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP INDEX album_title_idx ON album");
        $this->addSql("DROP INDEX album_length_idx ON album");
        $this->addSql("ALTER TABLE album CHANGE id id INT UNSIGNED DEFAULT 0 NOT NULL, CHANGE length length SMALLINT UNSIGNED DEFAULT NULL");
    }
}
