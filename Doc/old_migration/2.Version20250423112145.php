<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250423112145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abonnement CHANGE IdAbonnement IdAbonnement INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE document ADD type VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX `primary` ON livre');
        $this->addSql('ALTER TABLE livre CHANGE id_document IdDocument INT NOT NULL');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F99C497A3FD FOREIGN KEY (IdDocument) REFERENCES document (IdDocument) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livre ADD PRIMARY KEY (IdDocument)');
        $this->addSql('DROP INDEX `primary` ON sonore');
        $this->addSql('ALTER TABLE sonore CHANGE id_document IdDocument INT NOT NULL');
        $this->addSql('ALTER TABLE sonore ADD CONSTRAINT FK_9FB5BCDEC497A3FD FOREIGN KEY (IdDocument) REFERENCES document (IdDocument) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sonore ADD PRIMARY KEY (IdDocument)');
        $this->addSql('DROP INDEX `primary` ON titreperiodique');
        $this->addSql('ALTER TABLE titreperiodique CHANGE type format VARCHAR(50) DEFAULT NULL, CHANGE id_document IdDocument INT NOT NULL');
        $this->addSql('ALTER TABLE titreperiodique ADD CONSTRAINT FK_13BCEF62C497A3FD FOREIGN KEY (IdDocument) REFERENCES document (IdDocument) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE titreperiodique ADD PRIMARY KEY (IdDocument)');
        $this->addSql('DROP INDEX `primary` ON video');
        $this->addSql('ALTER TABLE video CHANGE id_document IdDocument INT NOT NULL');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CC497A3FD FOREIGN KEY (IdDocument) REFERENCES document (IdDocument) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video ADD PRIMARY KEY (IdDocument)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abonnement CHANGE IdAbonnement IdAbonnement INT NOT NULL');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CC497A3FD');
        $this->addSql('DROP INDEX `PRIMARY` ON video');
        $this->addSql('ALTER TABLE video CHANGE IdDocument id_document INT NOT NULL');
        $this->addSql('ALTER TABLE video ADD PRIMARY KEY (id_document)');
        $this->addSql('ALTER TABLE sonore DROP FOREIGN KEY FK_9FB5BCDEC497A3FD');
        $this->addSql('DROP INDEX `PRIMARY` ON sonore');
        $this->addSql('ALTER TABLE sonore CHANGE IdDocument id_document INT NOT NULL');
        $this->addSql('ALTER TABLE sonore ADD PRIMARY KEY (id_document)');
        $this->addSql('ALTER TABLE document DROP type');
        $this->addSql('ALTER TABLE titreperiodique DROP FOREIGN KEY FK_13BCEF62C497A3FD');
        $this->addSql('DROP INDEX `PRIMARY` ON titreperiodique');
        $this->addSql('ALTER TABLE titreperiodique CHANGE IdDocument id_document INT NOT NULL, CHANGE format type VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE titreperiodique ADD PRIMARY KEY (id_document)');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F99C497A3FD');
        $this->addSql('DROP INDEX `PRIMARY` ON livre');
        $this->addSql('ALTER TABLE livre CHANGE IdDocument id_document INT NOT NULL');
        $this->addSql('ALTER TABLE livre ADD PRIMARY KEY (id_document)');
    }
}
