<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260125173615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vente (id INT AUTO_INCREMENT NOT NULL, nombre INT NOT NULL, prix_unitaire DOUBLE PRECISION NOT NULL, date DATETIME NOT NULL, lot_id INT NOT NULL, INDEX IDX_888A2A4CA8CBA5F7 (lot_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE vente ADD CONSTRAINT FK_888A2A4CA8CBA5F7 FOREIGN KEY (lot_id) REFERENCES lot (id)');
        $this->addSql('ALTER TABLE lot CHANGE create_at created_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vente DROP FOREIGN KEY FK_888A2A4CA8CBA5F7');
        $this->addSql('DROP TABLE vente');
        $this->addSql('ALTER TABLE lot CHANGE created_at create_at DATETIME NOT NULL');
    }
}
