<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250425233356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abonnement (IdAbonnement INT AUTO_INCREMENT NOT NULL, statut_abonnement VARCHAR(50) DEFAULT NULL, date_abonnement DATE DEFAULT NULL, duree INT DEFAULT NULL, tarif NUMERIC(19, 4) DEFAULT NULL, remise INT DEFAULT NULL, PRIMARY KEY(IdAbonnement)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE auteur (IdAuteur INT AUTO_INCREMENT NOT NULL, prenom VARCHAR(50) DEFAULT NULL, nom VARCHAR(50) DEFAULT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(IdAuteur)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE document (IdDocument INT AUTO_INCREMENT NOT NULL, titre VARCHAR(50) DEFAULT NULL, annee DATE DEFAULT NULL, descritpion LONGTEXT DEFAULT NULL, thème VARCHAR(50) DEFAULT NULL, type VARCHAR(255) NOT NULL, isbn VARCHAR(50) DEFAULT NULL, nombre_page INT DEFAULT NULL, genre VARCHAR(50) DEFAULT NULL, numero INT DEFAULT NULL, date_publication DATE DEFAULT NULL, format VARCHAR(50) DEFAULT NULL, duree INT DEFAULT NULL, realisateur VARCHAR(50) DEFAULT NULL, interprete VARCHAR(50) DEFAULT NULL, PRIMARY KEY(IdDocument)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE ecrire (IdDocument INT NOT NULL, IdAuteur INT NOT NULL, INDEX IDX_918824CCC497A3FD (IdDocument), INDEX IdAuteur (IdAuteur), PRIMARY KEY(IdDocument, IdAuteur)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE emprunt (IdEmprunt INT AUTO_INCREMENT NOT NULL, date_reservation DATE DEFAULT NULL, date_rendu DATE DEFAULT NULL, IdUtilisateur INT DEFAULT NULL, INDEX IdUtilisateur (IdUtilisateur), PRIMARY KEY(IdEmprunt)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE empruntexemplaire (IdEmprunt INT NOT NULL, IdExemplaire INT NOT NULL, INDEX IDX_E6C32DB1A4089886 (IdEmprunt), INDEX IdExemplaire (IdExemplaire), PRIMARY KEY(IdEmprunt, IdExemplaire)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE exemplaire (IdExemplaire INT AUTO_INCREMENT NOT NULL, etat_physique VARCHAR(50) DEFAULT NULL, statut VARCHAR(50) DEFAULT NULL, IdDocument INT NOT NULL, INDEX IdDocument (IdDocument), PRIMARY KEY(IdExemplaire)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE utilisateur (IdUtilisateur INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) DEFAULT NULL, prenom VARCHAR(50) DEFAULT NULL, date_naissance DATE DEFAULT NULL, adresse1 VARCHAR(50) DEFAULT NULL, adresse2 VARCHAR(50) DEFAULT NULL, ville VARCHAR(50) DEFAULT NULL, pays VARCHAR(50) DEFAULT NULL, mail VARCHAR(50) NOT NULL, numero_telephone VARCHAR(50) DEFAULT NULL, situation VARCHAR(50) DEFAULT NULL, role VARCHAR(50) DEFAULT NULL, lien_justificatif VARCHAR(5000) DEFAULT NULL, statut VARCHAR(50) DEFAULT NULL, IdAbonnement INT DEFAULT NULL, INDEX IdAbonnement (IdAbonnement), PRIMARY KEY(IdUtilisateur)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE ecrire ADD CONSTRAINT FK_918824CCC497A3FD FOREIGN KEY (IdDocument) REFERENCES document (IdDocument) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ecrire ADD CONSTRAINT FK_918824CC9F3D7B8C FOREIGN KEY (IdAuteur) REFERENCES auteur (IdAuteur) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D7EE3FD73E FOREIGN KEY (IdUtilisateur) REFERENCES utilisateur (IdUtilisateur)');
        $this->addSql('ALTER TABLE empruntexemplaire ADD CONSTRAINT FK_E6C32DB1A4089886 FOREIGN KEY (IdEmprunt) REFERENCES emprunt (IdEmprunt)');
        $this->addSql('ALTER TABLE empruntexemplaire ADD CONSTRAINT FK_E6C32DB1C43DF980 FOREIGN KEY (IdExemplaire) REFERENCES exemplaire (IdExemplaire)');
        $this->addSql('ALTER TABLE exemplaire ADD CONSTRAINT FK_5EF83C92C497A3FD FOREIGN KEY (IdDocument) REFERENCES document (IdDocument)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3AFD7ADA9 FOREIGN KEY (IdAbonnement) REFERENCES abonnement (IdAbonnement)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ecrire DROP FOREIGN KEY FK_918824CCC497A3FD');
        $this->addSql('ALTER TABLE ecrire DROP FOREIGN KEY FK_918824CC9F3D7B8C');
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D7EE3FD73E');
        $this->addSql('ALTER TABLE empruntexemplaire DROP FOREIGN KEY FK_E6C32DB1A4089886');
        $this->addSql('ALTER TABLE empruntexemplaire DROP FOREIGN KEY FK_E6C32DB1C43DF980');
        $this->addSql('ALTER TABLE exemplaire DROP FOREIGN KEY FK_5EF83C92C497A3FD');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3AFD7ADA9');
        $this->addSql('DROP TABLE abonnement');
        $this->addSql('DROP TABLE auteur');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE ecrire');
        $this->addSql('DROP TABLE emprunt');
        $this->addSql('DROP TABLE empruntexemplaire');
        $this->addSql('DROP TABLE exemplaire');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
