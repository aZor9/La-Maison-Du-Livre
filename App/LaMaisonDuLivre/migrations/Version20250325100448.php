<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250325100448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abonnement (id VARCHAR(50) NOT NULL, tarif NUMERIC(19, 4) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, document_id INT NOT NULL, statut VARCHAR(50) NOT NULL, INDEX IDX_23A0E66C33F7837 (document_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE auteur (id INT AUTO_INCREMENT NOT NULL, prenom VARCHAR(50) NOT NULL, nom VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT NOT NULL, statut_abonnement VARCHAR(50) NOT NULL, date_fin_abonnement DATE DEFAULT NULL, idAbonnement VARCHAR(50) NOT NULL, INDEX IDX_C7440455B7E67651 (idAbonnement), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(50) NOT NULL, annee DATE NOT NULL, resume LONGTEXT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ecrire (document_id INT NOT NULL, auteur_id INT NOT NULL, INDEX IDX_918824CCC33F7837 (document_id), INDEX IDX_918824CC60BB6FE6 (auteur_id), PRIMARY KEY(document_id, auteur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employe (id INT NOT NULL, statut VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emprunt (id INT AUTO_INCREMENT NOT NULL, date_reservation DATE NOT NULL, date_rendu_prevision DATE NOT NULL, date_rendu DATE DEFAULT NULL, idUtilisateur INT NOT NULL, INDEX IDX_364071D75D419CCB (idUtilisateur), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emprunt_article (idArticle INT NOT NULL, idEmprunt INT NOT NULL, INDEX IDX_118C0CCB12836594 (idArticle), INDEX IDX_118C0CCB26F91A25 (idEmprunt), PRIMARY KEY(idArticle, idEmprunt)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livre (id INT NOT NULL, isbn VARCHAR(50) NOT NULL, nombre_page INT NOT NULL, genre VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sonore (id INT NOT NULL, duree INT NOT NULL, format VARCHAR(50) NOT NULL, interprete VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE titre_periodique (id INT NOT NULL, numero INT NOT NULL, date_publication DATE NOT NULL, categorie VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, date_naissance DATE NOT NULL, adresse1 VARCHAR(50) NOT NULL, adresse2 VARCHAR(50) DEFAULT NULL, ville VARCHAR(50) NOT NULL, pays VARCHAR(50) NOT NULL, mail VARCHAR(50) NOT NULL, numero_telephone VARCHAR(50) NOT NULL, situation VARCHAR(50) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT NOT NULL, duree INT NOT NULL, format VARCHAR(50) NOT NULL, realisateur VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66C33F7837 FOREIGN KEY (document_id) REFERENCES document (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455B7E67651 FOREIGN KEY (idAbonnement) REFERENCES abonnement (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455BF396750 FOREIGN KEY (id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ecrire ADD CONSTRAINT FK_918824CCC33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ecrire ADD CONSTRAINT FK_918824CC60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES auteur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employe ADD CONSTRAINT FK_F804D3B9BF396750 FOREIGN KEY (id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D75D419CCB FOREIGN KEY (idUtilisateur) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE emprunt_article ADD CONSTRAINT FK_118C0CCB12836594 FOREIGN KEY (idArticle) REFERENCES article (id)');
        $this->addSql('ALTER TABLE emprunt_article ADD CONSTRAINT FK_118C0CCB26F91A25 FOREIGN KEY (idEmprunt) REFERENCES emprunt (id)');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F99BF396750 FOREIGN KEY (id) REFERENCES document (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sonore ADD CONSTRAINT FK_9FB5BCDEBF396750 FOREIGN KEY (id) REFERENCES document (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE titre_periodique ADD CONSTRAINT FK_5807310CBF396750 FOREIGN KEY (id) REFERENCES document (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CBF396750 FOREIGN KEY (id) REFERENCES document (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66C33F7837');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455B7E67651');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455BF396750');
        $this->addSql('ALTER TABLE ecrire DROP FOREIGN KEY FK_918824CCC33F7837');
        $this->addSql('ALTER TABLE ecrire DROP FOREIGN KEY FK_918824CC60BB6FE6');
        $this->addSql('ALTER TABLE employe DROP FOREIGN KEY FK_F804D3B9BF396750');
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D75D419CCB');
        $this->addSql('ALTER TABLE emprunt_article DROP FOREIGN KEY FK_118C0CCB12836594');
        $this->addSql('ALTER TABLE emprunt_article DROP FOREIGN KEY FK_118C0CCB26F91A25');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F99BF396750');
        $this->addSql('ALTER TABLE sonore DROP FOREIGN KEY FK_9FB5BCDEBF396750');
        $this->addSql('ALTER TABLE titre_periodique DROP FOREIGN KEY FK_5807310CBF396750');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CBF396750');
        $this->addSql('DROP TABLE abonnement');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE auteur');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE ecrire');
        $this->addSql('DROP TABLE employe');
        $this->addSql('DROP TABLE emprunt');
        $this->addSql('DROP TABLE emprunt_article');
        $this->addSql('DROP TABLE livre');
        $this->addSql('DROP TABLE sonore');
        $this->addSql('DROP TABLE titre_periodique');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
