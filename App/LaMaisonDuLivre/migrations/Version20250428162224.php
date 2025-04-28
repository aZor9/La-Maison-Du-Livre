<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250428162224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ecrire ADD CONSTRAINT FK_918824CC88B266E3 FOREIGN KEY (id_document) REFERENCES document (id_document) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ecrire ADD CONSTRAINT FK_918824CC9F3D7B8C FOREIGN KEY (IdAuteur) REFERENCES auteur (IdAuteur) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D7EE3FD73E FOREIGN KEY (IdUtilisateur) REFERENCES utilisateur (IdUtilisateur)');
        $this->addSql('ALTER TABLE empruntexemplaire ADD CONSTRAINT FK_E6C32DB1A4089886 FOREIGN KEY (IdEmprunt) REFERENCES emprunt (IdEmprunt)');
        $this->addSql('ALTER TABLE empruntexemplaire ADD CONSTRAINT FK_E6C32DB1C43DF980 FOREIGN KEY (IdExemplaire) REFERENCES exemplaire (IdExemplaire)');
        $this->addSql('ALTER TABLE exemplaire ADD CONSTRAINT FK_5EF83C9288B266E3 FOREIGN KEY (id_document) REFERENCES document (id_document)');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F9988B266E3 FOREIGN KEY (id_document) REFERENCES document (id_document) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sonore ADD CONSTRAINT FK_9FB5BCDE88B266E3 FOREIGN KEY (id_document) REFERENCES document (id_document) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE titreperiodique ADD CONSTRAINT FK_13BCEF6288B266E3 FOREIGN KEY (id_document) REFERENCES document (id_document) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3AFD7ADA9 FOREIGN KEY (IdAbonnement) REFERENCES abonnement (IdAbonnement)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C88B266E3 FOREIGN KEY (id_document) REFERENCES document (id_document) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exemplaire DROP FOREIGN KEY FK_5EF83C9288B266E3');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C88B266E3');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F9988B266E3');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3AFD7ADA9');
        $this->addSql('ALTER TABLE titreperiodique DROP FOREIGN KEY FK_13BCEF6288B266E3');
        $this->addSql('ALTER TABLE ecrire DROP FOREIGN KEY FK_918824CC88B266E3');
        $this->addSql('ALTER TABLE ecrire DROP FOREIGN KEY FK_918824CC9F3D7B8C');
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D7EE3FD73E');
        $this->addSql('ALTER TABLE sonore DROP FOREIGN KEY FK_9FB5BCDE88B266E3');
        $this->addSql('ALTER TABLE empruntexemplaire DROP FOREIGN KEY FK_E6C32DB1A4089886');
        $this->addSql('ALTER TABLE empruntexemplaire DROP FOREIGN KEY FK_E6C32DB1C43DF980');
    }
}
