<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190512225716 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_6B01BC5BE7A1254A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__phone_number AS SELECT id, contact_id, phone_number, country_code, type, active FROM phone_number');
        $this->addSql('DROP TABLE phone_number');
        $this->addSql('CREATE TABLE phone_number (id INTEGER NOT NULL, contact_id INTEGER DEFAULT NULL, phone_number VARCHAR(255) NOT NULL COLLATE BINARY, country_code VARCHAR(255) NOT NULL COLLATE BINARY, type VARCHAR(255) DEFAULT NULL COLLATE BINARY, active BOOLEAN NOT NULL, "primary" BOOLEAN DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_6B01BC5BE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO phone_number (id, contact_id, phone_number, country_code, type, active) SELECT id, contact_id, phone_number, country_code, type, active FROM __temp__phone_number');
        $this->addSql('DROP TABLE __temp__phone_number');
        $this->addSql('CREATE INDEX IDX_6B01BC5BE7A1254A ON phone_number (contact_id)');
        $this->addSql('DROP INDEX IDX_4C62E6389B6B5FBA');
        $this->addSql('CREATE TEMPORARY TABLE __temp__contact AS SELECT id, account_id, first_name, last_name, address1, address2, city, state, postal_code, email, account_owner, active FROM contact');
        $this->addSql('DROP TABLE contact');
        $this->addSql('CREATE TABLE contact (id INTEGER NOT NULL, account_id INTEGER DEFAULT NULL, first_name VARCHAR(255) NOT NULL COLLATE BINARY, last_name VARCHAR(255) NOT NULL COLLATE BINARY, address1 VARCHAR(255) NOT NULL COLLATE BINARY, address2 VARCHAR(255) DEFAULT NULL COLLATE BINARY, city VARCHAR(255) NOT NULL COLLATE BINARY, state VARCHAR(255) NOT NULL COLLATE BINARY, postal_code VARCHAR(255) NOT NULL COLLATE BINARY, email VARCHAR(255) NOT NULL COLLATE BINARY, account_owner BOOLEAN NOT NULL, active BOOLEAN NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_4C62E6389B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO contact (id, account_id, first_name, last_name, address1, address2, city, state, postal_code, email, account_owner, active) SELECT id, account_id, first_name, last_name, address1, address2, city, state, postal_code, email, account_owner, active FROM __temp__contact');
        $this->addSql('DROP TABLE __temp__contact');
        $this->addSql('CREATE INDEX IDX_4C62E6389B6B5FBA ON contact (account_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__account AS SELECT id, active FROM account');
        $this->addSql('DROP TABLE account');
        $this->addSql('CREATE TABLE account (id INTEGER NOT NULL, active BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO account (id, active) SELECT id, active FROM __temp__account');
        $this->addSql('DROP TABLE __temp__account');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__account AS SELECT id, active FROM account');
        $this->addSql('DROP TABLE account');
        $this->addSql('CREATE TABLE account (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, active BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO account (id, active) SELECT id, active FROM __temp__account');
        $this->addSql('DROP TABLE __temp__account');
        $this->addSql('DROP INDEX IDX_4C62E6389B6B5FBA');
        $this->addSql('CREATE TEMPORARY TABLE __temp__contact AS SELECT id, account_id, first_name, last_name, address1, address2, city, state, postal_code, email, account_owner, active FROM contact');
        $this->addSql('DROP TABLE contact');
        $this->addSql('CREATE TABLE contact (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, account_id INTEGER DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, address1 VARCHAR(255) NOT NULL, address2 VARCHAR(255) DEFAULT NULL, city VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, account_owner BOOLEAN NOT NULL, active BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO contact (id, account_id, first_name, last_name, address1, address2, city, state, postal_code, email, account_owner, active) SELECT id, account_id, first_name, last_name, address1, address2, city, state, postal_code, email, account_owner, active FROM __temp__contact');
        $this->addSql('DROP TABLE __temp__contact');
        $this->addSql('CREATE INDEX IDX_4C62E6389B6B5FBA ON contact (account_id)');
        $this->addSql('DROP INDEX IDX_6B01BC5BE7A1254A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__phone_number AS SELECT id, contact_id, phone_number, country_code, type, active FROM phone_number');
        $this->addSql('DROP TABLE phone_number');
        $this->addSql('CREATE TABLE phone_number (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contact_id INTEGER DEFAULT NULL, phone_number VARCHAR(255) NOT NULL, country_code VARCHAR(255) NOT NULL, type VARCHAR(255) DEFAULT NULL, active BOOLEAN NOT NULL, primary_phone_number BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO phone_number (id, contact_id, phone_number, country_code, type, active) SELECT id, contact_id, phone_number, country_code, type, active FROM __temp__phone_number');
        $this->addSql('DROP TABLE __temp__phone_number');
        $this->addSql('CREATE INDEX IDX_6B01BC5BE7A1254A ON phone_number (contact_id)');
    }
}
