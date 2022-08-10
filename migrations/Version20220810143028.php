<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220810143028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Delete Table SentMail';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE sentmail');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sentmail (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, mailings_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D0BD71295E2E5887 (mailings_id), INDEX IDX_D0BD712967B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE sentmail ADD CONSTRAINT FK_D0BD712967B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE sentmail ADD CONSTRAINT FK_D0BD71295E2E5887 FOREIGN KEY (mailings_id) REFERENCES mailing (id)');
    }
}