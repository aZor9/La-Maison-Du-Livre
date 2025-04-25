<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250425230046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_918824CCC497A3FD ON ecrire');
        $this->addSql('DROP INDEX `primary` ON ecrire');
        $this->addSql('ALTER TABLE ecrire CHANGE IdDocument id_document INT NOT NULL');
        $this->addSql('ALTER TABLE ecrire ADD CONSTRAINT FK_918824CC88B266E3 FOREIGN KEY (id_document) REFERENCES document (IdDocument) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ecrire ADD CONSTRAINT FK_918824CC9F3D7B8C FOREIGN KEY (IdAuteur) REFERENCES auteur (IdAuteur) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_918824CC88B266E3 ON ecrire (id_document)');
        $this->addSql('ALTER TABLE ecrire ADD PRIMARY KEY (id_document, IdAuteur)');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D7EE3FD73E FOREIGN KEY (IdUtilisateur) REFERENCES utilisateur (IdUtilisateur)');
        $this->addSql('ALTER TABLE empruntexemplaire ADD CONSTRAINT FK_E6C32DB1A4089886 FOREIGN KEY (IdEmprunt) REFERENCES emprunt (IdEmprunt)');
        $this->addSql('ALTER TABLE empruntexemplaire ADD CONSTRAINT FK_E6C32DB1C43DF980 FOREIGN KEY (IdExemplaire) REFERENCES exemplaire (IdExemplaire)');
        $this->addSql('ALTER TABLE exemplaire ADD CONSTRAINT FK_5EF83C92C497A3FD FOREIGN KEY (IdDocument) REFERENCES document (IdDocument)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3AFD7ADA9 FOREIGN KEY (IdAbonnement) REFERENCES abonnement (IdAbonnement)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3AFD7ADA9');
        $this->addSql('ALTER TABLE exemplaire DROP FOREIGN KEY FK_5EF83C92C497A3FD');
        $this->addSql('ALTER TABLE empruntexemplaire DROP FOREIGN KEY FK_E6C32DB1A4089886');
        $this->addSql('ALTER TABLE empruntexemplaire DROP FOREIGN KEY FK_E6C32DB1C43DF980');
        $this->addSql('ALTER TABLE ecrire DROP FOREIGN KEY FK_918824CC88B266E3');
        $this->addSql('ALTER TABLE ecrire DROP FOREIGN KEY FK_918824CC9F3D7B8C');
        $this->addSql('DROP INDEX IDX_918824CC88B266E3 ON ecrire');
        $this->addSql('DROP INDEX `PRIMARY` ON ecrire');
        $this->addSql('ALTER TABLE ecrire CHANGE id_document IdDocument INT NOT NULL');
        $this->addSql('CREATE INDEX IDX_918824CCC497A3FD ON ecrire (IdDocument)');
        $this->addSql('ALTER TABLE ecrire ADD PRIMARY KEY (IdDocument, IdAuteur)');
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D7EE3FD73E');
    }
}
