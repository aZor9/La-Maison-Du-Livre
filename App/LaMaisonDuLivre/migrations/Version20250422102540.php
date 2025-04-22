<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250422102540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX `primary` ON abonnement');
        $this->addSql('ALTER TABLE abonnement CHANGE IdAbonnement id_abonnement INT NOT NULL, CHANGE StatutAbonnement statut_abonnement VARCHAR(50) DEFAULT NULL, CHANGE DateAbonnement date_abonnement DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE abonnement ADD PRIMARY KEY (id_abonnement)');
        $this->addSql('ALTER TABLE auteur CHANGE Description description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE document DROP Auteur, CHANGE Descritpion descritpion LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE ecrire DROP FOREIGN KEY ecrire_ibfk_1');
        $this->addSql('ALTER TABLE ecrire DROP FOREIGN KEY ecrire_ibfk_2');
        $this->addSql('ALTER TABLE ecrire ADD CONSTRAINT FK_918824CCC497A3FD FOREIGN KEY (IdDocument) REFERENCES document (IdDocument) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ecrire ADD CONSTRAINT FK_918824CC9F3D7B8C FOREIGN KEY (IdAuteur) REFERENCES auteur (IdAuteur) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE emprunt MODIFY IdEmprunt INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON emprunt');
        $this->addSql('ALTER TABLE emprunt ADD date_reservation DATE DEFAULT NULL, ADD date_rendu DATE DEFAULT NULL, DROP DateReservation, DROP DateRendu, CHANGE IdUtilisateur IdUtilisateur INT DEFAULT NULL, CHANGE IdEmprunt id_emprunt INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE emprunt ADD PRIMARY KEY (id_emprunt)');
        $this->addSql('DROP INDEX `primary` ON exemplaire');
        $this->addSql('ALTER TABLE exemplaire ADD id_document INT NOT NULL, CHANGE IdExemplaire id_exemplaire INT NOT NULL, CHANGE EtatPhysique etat_physique VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE exemplaire ADD PRIMARY KEY (id_exemplaire)');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY livre_ibfk_1');
        $this->addSql('DROP INDEX `primary` ON livre');
        $this->addSql('ALTER TABLE livre CHANGE IdDocument id_document INT NOT NULL, CHANGE NombrePage nombre_page INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livre ADD PRIMARY KEY (id_document)');
        $this->addSql('ALTER TABLE sonore DROP FOREIGN KEY sonore_ibfk_1');
        $this->addSql('DROP INDEX `primary` ON sonore');
        $this->addSql('ALTER TABLE sonore CHANGE IdDocument id_document INT NOT NULL');
        $this->addSql('ALTER TABLE sonore ADD PRIMARY KEY (id_document)');
        $this->addSql('ALTER TABLE titreperiodique DROP FOREIGN KEY titreperiodique_ibfk_1');
        $this->addSql('DROP INDEX `primary` ON titreperiodique');
        $this->addSql('ALTER TABLE titreperiodique CHANGE IdDocument id_document INT NOT NULL, CHANGE DatePublication date_publication DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE titreperiodique ADD PRIMARY KEY (id_document)');
        $this->addSql('ALTER TABLE utilisateur MODIFY IdUtilisateur INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD numero_telephone VARCHAR(50) DEFAULT NULL, ADD lien_justificatif VARCHAR(50) DEFAULT NULL, DROP NumeroTelephone, DROP LienJustificatif, CHANGE IdUtilisateur id_utilisateur INT AUTO_INCREMENT NOT NULL, CHANGE DateNaissance date_naissance DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD PRIMARY KEY (id_utilisateur)');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY video_ibfk_1');
        $this->addSql('DROP INDEX `primary` ON video');
        $this->addSql('ALTER TABLE video CHANGE IdDocument id_document INT NOT NULL');
        $this->addSql('ALTER TABLE video ADD PRIMARY KEY (id_document)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX `PRIMARY` ON abonnement');
        $this->addSql('ALTER TABLE abonnement CHANGE id_abonnement IdAbonnement INT NOT NULL, CHANGE statut_abonnement StatutAbonnement VARCHAR(50) DEFAULT NULL, CHANGE date_abonnement DateAbonnement DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE abonnement ADD PRIMARY KEY (IdAbonnement)');
        $this->addSql('DROP INDEX `PRIMARY` ON video');
        $this->addSql('ALTER TABLE video CHANGE id_document IdDocument INT NOT NULL');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT video_ibfk_1 FOREIGN KEY (IdDocument) REFERENCES document (IdDocument) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE video ADD PRIMARY KEY (IdDocument)');
        $this->addSql('ALTER TABLE auteur CHANGE description Description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur MODIFY id_utilisateur INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD NumeroTelephone VARCHAR(50) DEFAULT NULL, ADD LienJustificatif VARCHAR(50) DEFAULT NULL, DROP numero_telephone, DROP lien_justificatif, CHANGE id_utilisateur IdUtilisateur INT AUTO_INCREMENT NOT NULL, CHANGE date_naissance DateNaissance DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD PRIMARY KEY (IdUtilisateur)');
        $this->addSql('ALTER TABLE document ADD Auteur VARCHAR(50) DEFAULT NULL, CHANGE descritpion Descritpion TEXT DEFAULT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON titreperiodique');
        $this->addSql('ALTER TABLE titreperiodique CHANGE id_document IdDocument INT NOT NULL, CHANGE date_publication DatePublication DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE titreperiodique ADD CONSTRAINT titreperiodique_ibfk_1 FOREIGN KEY (IdDocument) REFERENCES document (IdDocument) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE titreperiodique ADD PRIMARY KEY (IdDocument)');
        $this->addSql('ALTER TABLE ecrire DROP FOREIGN KEY FK_918824CCC497A3FD');
        $this->addSql('ALTER TABLE ecrire DROP FOREIGN KEY FK_918824CC9F3D7B8C');
        $this->addSql('ALTER TABLE ecrire ADD CONSTRAINT ecrire_ibfk_1 FOREIGN KEY (IdDocument) REFERENCES document (IdDocument) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE ecrire ADD CONSTRAINT ecrire_ibfk_2 FOREIGN KEY (IdAuteur) REFERENCES auteur (IdAuteur) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE emprunt MODIFY id_emprunt INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON emprunt');
        $this->addSql('ALTER TABLE emprunt ADD DateReservation DATE DEFAULT NULL, ADD DateRendu DATE DEFAULT NULL, DROP date_reservation, DROP date_rendu, CHANGE IdUtilisateur IdUtilisateur INT NOT NULL, CHANGE id_emprunt IdEmprunt INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE emprunt ADD PRIMARY KEY (IdEmprunt)');
        $this->addSql('DROP INDEX `PRIMARY` ON livre');
        $this->addSql('ALTER TABLE livre CHANGE id_document IdDocument INT NOT NULL, CHANGE nombre_page NombrePage INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT livre_ibfk_1 FOREIGN KEY (IdDocument) REFERENCES document (IdDocument) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE livre ADD PRIMARY KEY (IdDocument)');
        $this->addSql('DROP INDEX `PRIMARY` ON sonore');
        $this->addSql('ALTER TABLE sonore CHANGE id_document IdDocument INT NOT NULL');
        $this->addSql('ALTER TABLE sonore ADD CONSTRAINT sonore_ibfk_1 FOREIGN KEY (IdDocument) REFERENCES document (IdDocument) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE sonore ADD PRIMARY KEY (IdDocument)');
        $this->addSql('DROP INDEX `PRIMARY` ON exemplaire');
        $this->addSql('ALTER TABLE exemplaire ADD IdExemplaire INT NOT NULL, DROP id_exemplaire, DROP id_document, CHANGE etat_physique EtatPhysique VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE exemplaire ADD PRIMARY KEY (IdExemplaire)');
    }
}
