<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220121152154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employe (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employe_employe (employe_source INT NOT NULL, employe_target INT NOT NULL, INDEX IDX_3C0BBF1A31AC648A (employe_source), INDEX IDX_3C0BBF1A28493405 (employe_target), PRIMARY KEY(employe_source, employe_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employe_employe ADD CONSTRAINT FK_3C0BBF1A31AC648A FOREIGN KEY (employe_source) REFERENCES employe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employe_employe ADD CONSTRAINT FK_3C0BBF1A28493405 FOREIGN KEY (employe_target) REFERENCES employe (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employe_employe DROP FOREIGN KEY FK_3C0BBF1A31AC648A');
        $this->addSql('ALTER TABLE employe_employe DROP FOREIGN KEY FK_3C0BBF1A28493405');
        $this->addSql('DROP TABLE employe');
        $this->addSql('DROP TABLE employe_employe');
    }
}
