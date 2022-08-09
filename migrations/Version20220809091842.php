<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220809091842 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Drop contact';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE maincustomer DROP contact');
        $this->addSql('ALTER TABLE partner DROP contact');
        $this->addSql('ALTER TABLE sporthall DROP contact');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE maincustomer ADD contact VARCHAR(190) NOT NULL');
        $this->addSql('ALTER TABLE partner ADD contact VARCHAR(190) NOT NULL');
        $this->addSql('ALTER TABLE sporthall ADD contact VARCHAR(190) NOT NULL');
    }
}