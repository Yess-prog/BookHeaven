<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250511112156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, date_commande DATE NOT NULL, statut VARCHAR(255) NOT NULL, montant_total DOUBLE PRECISION NOT NULL, INDEX IDX_6EEAA67DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livre_commande (id INT AUTO_INCREMENT NOT NULL, livre_id INT NOT NULL, commande_id INT NOT NULL, quantite INT NOT NULL, prix DOUBLE PRECISION NOT NULL, INDEX IDX_22140D437D925CB (livre_id), INDEX IDX_22140D482EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE livre_commande ADD CONSTRAINT FK_22140D437D925CB FOREIGN KEY (livre_id) REFERENCES livres (id)');
        $this->addSql('ALTER TABLE livre_commande ADD CONSTRAINT FK_22140D482EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE user ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD date_creation DATETIME NOT NULL, ADD adresse VARCHAR(255) DEFAULT NULL, CHANGE password mot_de_passe VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX uniq_identifier_email ON user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DA76ED395');
        $this->addSql('ALTER TABLE livre_commande DROP FOREIGN KEY FK_22140D437D925CB');
        $this->addSql('ALTER TABLE livre_commande DROP FOREIGN KEY FK_22140D482EA2E54');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE livre_commande');
        $this->addSql('ALTER TABLE `user` ADD password VARCHAR(255) NOT NULL, DROP mot_de_passe, DROP nom, DROP prenom, DROP date_creation, DROP adresse');
        $this->addSql('DROP INDEX uniq_8d93d649e7927c74 ON `user`');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON `user` (email)');
    }
}
