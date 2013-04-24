<?php

namespace TravisDoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130424153319 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE artist (id integer unsigned, name VARCHAR(32) NOT NULL, birthday DATETIME NOT NULL, INDEX artist_name_idx (name), INDEX artist_birthday_idx (birthday), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE album CHANGE id id integer unsigned, CHANGE length length smallint unsigned");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE artist");
        $this->addSql("ALTER TABLE album CHANGE id id INT UNSIGNED DEFAULT 0 NOT NULL, CHANGE length length SMALLINT UNSIGNED DEFAULT NULL");
    }
}
