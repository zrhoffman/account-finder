<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190512034952 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE phone_number (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contact_id INTEGER DEFAULT NULL, phone_number VARCHAR(255) NOT NULL, country_code VARCHAR(255) NOT NULL, type VARCHAR(255) DEFAULT NULL, active BOOLEAN NOT NULL, primary_phone_number BOOLEAN NOT NULL)');
        $this->addSql('CREATE INDEX IDX_6B01BC5BE7A1254A ON phone_number (contact_id)');
        $this->addSql('CREATE TABLE contact (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, account_id INTEGER DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, address1 VARCHAR(255) NOT NULL, address2 VARCHAR(255) DEFAULT NULL, city VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, account_owner BOOLEAN NOT NULL, active BOOLEAN NOT NULL)');
        $this->addSql('CREATE INDEX IDX_4C62E6389B6B5FBA ON contact (account_id)');
        $this->addSql('CREATE TABLE account (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, active BOOLEAN NOT NULL)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE phone_number');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE account');
    }
}
