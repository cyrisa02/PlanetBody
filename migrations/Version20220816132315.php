<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220816132315 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create relation ManyToOne Sporthall and Partner';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sporthall ADD partners_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sporthall ADD CONSTRAINT FK_8EFADBC4BDE7F1C6 FOREIGN KEY (partners_id) REFERENCES partner (id)');
        $this->addSql('CREATE INDEX IDX_8EFADBC4BDE7F1C6 ON sporthall (partners_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sporthall DROP FOREIGN KEY FK_8EFADBC4BDE7F1C6');
        $this->addSql('DROP INDEX IDX_8EFADBC4BDE7F1C6 ON sporthall');
        $this->addSql('ALTER TABLE sporthall DROP partners_id');
    }
}