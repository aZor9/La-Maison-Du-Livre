<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250428111711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ecrire RENAME INDEX idx_918824ccc497a3fd TO IDX_918824CC88B266E3');
        $this->addSql('ALTER TABLE utilisateur ADD surnom VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP surnom');
        $this->addSql('ALTER TABLE ecrire RENAME INDEX idx_918824cc88b266e3 TO IDX_918824CCC497A3FD');
    }
}
