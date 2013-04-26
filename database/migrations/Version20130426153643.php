<?php

namespace TravisDoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130426153643 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE system_user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(128) NOT NULL, password VARCHAR(128) NOT NULL, username VARCHAR(128) NOT NULL, first_name VARCHAR(128) DEFAULT NULL, last_name VARCHAR(128) DEFAULT NULL, created DATETIME NOT NULL, UNIQUE INDEX UNIQ_9C5F65BFE7927C74 (email), UNIQUE INDEX UNIQ_9C5F65BFF85E0677 (username), INDEX system_user_email_password_idx (email, password), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE album CHANGE length length smallint unsigned");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE system_user");
        $this->addSql("ALTER TABLE album CHANGE length length SMALLINT UNSIGNED DEFAULT NULL");
    }
}
