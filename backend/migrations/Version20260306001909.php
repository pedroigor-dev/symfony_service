<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260306001909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE appointment (id SERIAL NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, description VARCHAR(255) NOT NULL, pet_id INT NOT NULL, owner_id INT NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_FE38F844966F7FB6 ON appointment (pet_id)');
        $this->addSql('CREATE INDEX IDX_FE38F8447E3C61F9 ON appointment (owner_id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844966F7FB6 FOREIGN KEY (pet_id) REFERENCES pet (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F8447E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE appointment DROP CONSTRAINT FK_FE38F844966F7FB6');
        $this->addSql('ALTER TABLE appointment DROP CONSTRAINT FK_FE38F8447E3C61F9');
        $this->addSql('DROP TABLE appointment');
    }
}
