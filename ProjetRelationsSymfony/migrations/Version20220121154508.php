<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220121154508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employe_mma (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne_mma (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supervision_mma (id INT AUTO_INCREMENT NOT NULL, superviseur_id INT DEFAULT NULL, supervisee_id INT DEFAULT NULL, INDEX IDX_D334C8D1B7BB80FF (superviseur_id), INDEX IDX_D334C8D19E97DBD8 (supervisee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE supervision_mma ADD CONSTRAINT FK_D334C8D1B7BB80FF FOREIGN KEY (superviseur_id) REFERENCES employe_mma (id)');
        $this->addSql('ALTER TABLE supervision_mma ADD CONSTRAINT FK_D334C8D19E97DBD8 FOREIGN KEY (supervisee_id) REFERENCES employe_mma (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE supervision_mma DROP FOREIGN KEY FK_D334C8D1B7BB80FF');
        $this->addSql('ALTER TABLE supervision_mma DROP FOREIGN KEY FK_D334C8D19E97DBD8');
        $this->addSql('DROP TABLE employe_mma');
        $this->addSql('DROP TABLE personne_mma');
        $this->addSql('DROP TABLE supervision_mma');
    }
}
