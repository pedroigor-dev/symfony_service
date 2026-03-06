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
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appointment (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, description VARCHAR(255) NOT NULL, pet_id INT NOT NULL, owner_id INT NOT NULL, INDEX IDX_FE38F844966F7FB6 (pet_id), INDEX IDX_FE38F8447E3C61F9 (owner_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844966F7FB6 FOREIGN KEY (pet_id) REFERENCES pet (id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F8447E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F844966F7FB6');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F8447E3C61F9');
        $this->addSql('DROP TABLE appointment');
    }
}
