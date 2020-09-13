<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200912220134 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE owner (id VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE owner_pet (owner_id VARCHAR(255) NOT NULL, pet_id VARCHAR(255) NOT NULL, PRIMARY KEY(owner_id, pet_id))');
        $this->addSql('CREATE INDEX IDX_4B9985CF7E3C61F9 ON owner_pet (owner_id)');
        $this->addSql('CREATE INDEX IDX_4B9985CF966F7FB6 ON owner_pet (pet_id)');
        $this->addSql('CREATE TABLE pet (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, birth_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE vet (id VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, speciality VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE visit (id VARCHAR(255) NOT NULL, pet VARCHAR(255) NOT NULL, visit_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE owner_pet ADD CONSTRAINT FK_4B9985CF7E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE owner_pet ADD CONSTRAINT FK_4B9985CF966F7FB6 FOREIGN KEY (pet_id) REFERENCES pet (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE owner_pet DROP CONSTRAINT FK_4B9985CF7E3C61F9');
        $this->addSql('ALTER TABLE owner_pet DROP CONSTRAINT FK_4B9985CF966F7FB6');
        $this->addSql('DROP TABLE owner');
        $this->addSql('DROP TABLE owner_pet');
        $this->addSql('DROP TABLE pet');
        $this->addSql('DROP TABLE vet');
        $this->addSql('DROP TABLE visit');
    }
}
