<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250322122407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX `primary` ON document');
        $this->addSql('ALTER TABLE document DROP auteur, CHANGE id_document id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE document ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66C33F7837 FOREIGN KEY (document_id) REFERENCES document (id)');
        $this->addSql('DROP INDEX IDX_C7440455F1D74413 ON client');
        $this->addSql('DROP INDEX `primary` ON client');
        $this->addSql('ALTER TABLE client CHANGE id_utilisateur id INT NOT NULL, CHANGE abonnement_id idAbonnement VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455B7E67651 FOREIGN KEY (idAbonnement) REFERENCES abonnement (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455BF396750 FOREIGN KEY (id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_C7440455B7E67651 ON client (idAbonnement)');
        $this->addSql('ALTER TABLE client ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE document MODIFY id_document INT NOT NULL');
        $this->addSql('ALTER TABLE ecrire ADD CONSTRAINT FK_918824CCC33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ecrire ADD CONSTRAINT FK_918824CC60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES auteur (id) ON DELETE CASCADE');
        $this->addSql('DROP INDEX `primary` ON employe');
        $this->addSql('ALTER TABLE employe CHANGE id_utilisateur id INT NOT NULL');
        $this->addSql('ALTER TABLE employe ADD CONSTRAINT FK_F804D3B9BF396750 FOREIGN KEY (id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employe ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE emprunt MODIFY id_emprunt INT NOT NULL');
        $this->addSql('DROP INDEX IDX_364071D7FB88E14F ON emprunt');
        $this->addSql('DROP INDEX `primary` ON emprunt');
        $this->addSql('ALTER TABLE emprunt CHANGE id_emprunt id INT AUTO_INCREMENT NOT NULL, CHANGE utilisateur_id idUtilisateur INT NOT NULL');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D75D419CCB FOREIGN KEY (idUtilisateur) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_364071D75D419CCB ON emprunt (idUtilisateur)');
        $this->addSql('ALTER TABLE emprunt ADD PRIMARY KEY (id)');
        $this->addSql('DROP INDEX IDX_118C0CCB7294869C ON emprunt_article');
        $this->addSql('DROP INDEX IDX_118C0CCBAE7FEF94 ON emprunt_article');
        $this->addSql('DROP INDEX `primary` ON emprunt_article');
        $this->addSql('ALTER TABLE emprunt_article ADD idArticle INT NOT NULL, ADD idEmprunt INT NOT NULL, DROP article_id, DROP emprunt_id');
        $this->addSql('ALTER TABLE emprunt_article ADD CONSTRAINT FK_118C0CCB12836594 FOREIGN KEY (idArticle) REFERENCES article (id)');
        $this->addSql('ALTER TABLE emprunt_article ADD CONSTRAINT FK_118C0CCB26F91A25 FOREIGN KEY (idEmprunt) REFERENCES emprunt (id)');
        $this->addSql('CREATE INDEX IDX_118C0CCB12836594 ON emprunt_article (idArticle)');
        $this->addSql('CREATE INDEX IDX_118C0CCB26F91A25 ON emprunt_article (idEmprunt)');
        $this->addSql('ALTER TABLE emprunt_article ADD PRIMARY KEY (idArticle, idEmprunt)');
        $this->addSql('DROP INDEX `primary` ON livre');
        $this->addSql('ALTER TABLE livre CHANGE id_document id INT NOT NULL');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F99BF396750 FOREIGN KEY (id) REFERENCES document (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livre ADD PRIMARY KEY (id)');
        $this->addSql('DROP INDEX `primary` ON sonore');
        $this->addSql('ALTER TABLE sonore CHANGE id_document id INT NOT NULL');
        $this->addSql('ALTER TABLE sonore ADD CONSTRAINT FK_9FB5BCDEBF396750 FOREIGN KEY (id) REFERENCES document (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sonore ADD PRIMARY KEY (id)');
        $this->addSql('DROP INDEX `primary` ON titre_periodique');
        $this->addSql('ALTER TABLE titre_periodique CHANGE id_document id INT NOT NULL');
        $this->addSql('ALTER TABLE titre_periodique ADD CONSTRAINT FK_5807310CBF396750 FOREIGN KEY (id) REFERENCES document (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE titre_periodique ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE utilisateur MODIFY id_utilisateur INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur CHANGE id_utilisateur id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD PRIMARY KEY (id)');
        $this->addSql('DROP INDEX `primary` ON video');
        $this->addSql('ALTER TABLE video CHANGE id_document id INT NOT NULL');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CBF396750 FOREIGN KEY (id) REFERENCES document (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F99BF396750');
        $this->addSql('DROP INDEX `PRIMARY` ON livre');
        $this->addSql('ALTER TABLE livre CHANGE id id_document INT NOT NULL');
        $this->addSql('ALTER TABLE livre ADD PRIMARY KEY (id_document)');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66C33F7837');
        $this->addSql('ALTER TABLE utilisateur MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur CHANGE id id_utilisateur INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD PRIMARY KEY (id_utilisateur)');
        $this->addSql('ALTER TABLE document MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON document');
        $this->addSql('ALTER TABLE document ADD auteur VARCHAR(50) NOT NULL, CHANGE id id_document INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE document ADD PRIMARY KEY (id_document)');
        $this->addSql('ALTER TABLE titre_periodique DROP FOREIGN KEY FK_5807310CBF396750');
        $this->addSql('DROP INDEX `PRIMARY` ON titre_periodique');
        $this->addSql('ALTER TABLE titre_periodique CHANGE id id_document INT NOT NULL');
        $this->addSql('ALTER TABLE titre_periodique ADD PRIMARY KEY (id_document)');
        $this->addSql('ALTER TABLE emprunt MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D75D419CCB');
        $this->addSql('DROP INDEX IDX_364071D75D419CCB ON emprunt');
        $this->addSql('DROP INDEX `PRIMARY` ON emprunt');
        $this->addSql('ALTER TABLE emprunt CHANGE id id_emprunt INT AUTO_INCREMENT NOT NULL, CHANGE idUtilisateur utilisateur_id INT NOT NULL');
        $this->addSql('CREATE INDEX IDX_364071D7FB88E14F ON emprunt (utilisateur_id)');
        $this->addSql('ALTER TABLE emprunt ADD PRIMARY KEY (id_emprunt)');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CBF396750');
        $this->addSql('DROP INDEX `PRIMARY` ON video');
        $this->addSql('ALTER TABLE video CHANGE id id_document INT NOT NULL');
        $this->addSql('ALTER TABLE video ADD PRIMARY KEY (id_document)');
        $this->addSql('ALTER TABLE sonore DROP FOREIGN KEY FK_9FB5BCDEBF396750');
        $this->addSql('DROP INDEX `PRIMARY` ON sonore');
        $this->addSql('ALTER TABLE sonore CHANGE id id_document INT NOT NULL');
        $this->addSql('ALTER TABLE sonore ADD PRIMARY KEY (id_document)');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455B7E67651');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455BF396750');
        $this->addSql('DROP INDEX IDX_C7440455B7E67651 ON client');
        $this->addSql('DROP INDEX `PRIMARY` ON client');
        $this->addSql('ALTER TABLE client CHANGE id id_utilisateur INT NOT NULL, CHANGE idAbonnement abonnement_id VARCHAR(50) NOT NULL');
        $this->addSql('CREATE INDEX IDX_C7440455F1D74413 ON client (abonnement_id)');
        $this->addSql('ALTER TABLE client ADD PRIMARY KEY (id_utilisateur)');
        $this->addSql('ALTER TABLE ecrire DROP FOREIGN KEY FK_918824CCC33F7837');
        $this->addSql('ALTER TABLE ecrire DROP FOREIGN KEY FK_918824CC60BB6FE6');
        $this->addSql('ALTER TABLE employe DROP FOREIGN KEY FK_F804D3B9BF396750');
        $this->addSql('DROP INDEX `PRIMARY` ON employe');
        $this->addSql('ALTER TABLE employe CHANGE id id_utilisateur INT NOT NULL');
        $this->addSql('ALTER TABLE employe ADD PRIMARY KEY (id_utilisateur)');
        $this->addSql('ALTER TABLE emprunt_article DROP FOREIGN KEY FK_118C0CCB12836594');
        $this->addSql('ALTER TABLE emprunt_article DROP FOREIGN KEY FK_118C0CCB26F91A25');
        $this->addSql('DROP INDEX IDX_118C0CCB12836594 ON emprunt_article');
        $this->addSql('DROP INDEX IDX_118C0CCB26F91A25 ON emprunt_article');
        $this->addSql('DROP INDEX `PRIMARY` ON emprunt_article');
        $this->addSql('ALTER TABLE emprunt_article ADD article_id INT NOT NULL, ADD emprunt_id INT NOT NULL, DROP idArticle, DROP idEmprunt');
        $this->addSql('CREATE INDEX IDX_118C0CCB7294869C ON emprunt_article (article_id)');
        $this->addSql('CREATE INDEX IDX_118C0CCBAE7FEF94 ON emprunt_article (emprunt_id)');
        $this->addSql('ALTER TABLE emprunt_article ADD PRIMARY KEY (article_id, emprunt_id)');
    }
}
