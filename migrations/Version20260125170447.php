<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260125170447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mortalite (id INT AUTO_INCREMENT NOT NULL, nombre INT NOT NULL, cause VARCHAR(255) DEFAULT NULL, date DATETIME NOT NULL, lot_id INT NOT NULL, INDEX IDX_4D858153A8CBA5F7 (lot_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE mortalite ADD CONSTRAINT FK_4D858153A8CBA5F7 FOREIGN KEY (lot_id) REFERENCES lot (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mortalite DROP FOREIGN KEY FK_4D858153A8CBA5F7');
        $this->addSql('DROP TABLE mortalite');
    }
}
