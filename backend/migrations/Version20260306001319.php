<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260306001319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE pet (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, species VARCHAR(100) NOT NULL, breed VARCHAR(100) NOT NULL, birthday DATE DEFAULT NULL, owner_id INT NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_E4529B857E3C61F9 ON pet (owner_id)');
        $this->addSql('ALTER TABLE pet ADD CONSTRAINT FK_E4529B857E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE pet DROP CONSTRAINT FK_E4529B857E3C61F9');
        $this->addSql('DROP TABLE pet');
    }
}
